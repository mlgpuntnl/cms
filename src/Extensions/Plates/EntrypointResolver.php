<?php

declare(strict_types=1);

namespace Timo\Cms\Extensions\Plates;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use stdClass;
use Timo\Cms\Enums\AppEnv;
use Timo\Cms\Util\Config;

class EntrypointResolver implements ExtensionInterface
{
    private ?string $entrypoint = null;
    private string $baseUrl = '';
    private ?stdClass $manifest = null;
    private array $scripts = [];
    private array $styles = [];
    public mixed $template;

    public function __construct(private Config $config)
    {
        if ($this->config->appEnv === AppEnv::DEVELOPMENT) {
            $this->baseUrl = 'http://localhost:' . $_ENV['APP_PORT'] . '/';
        }
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('load_entrypoint', [$this, 'loadEntryPoint']);
        $engine->registerFunction('load_scripts', [$this, 'loadScripts']);
        $engine->registerFunction('load_styles', [$this, 'loadStyles']);
    }

    public function loadScripts(): string
    {
        $this->assertEntrypointLoaded();
        if ($this->config->appEnv === AppEnv::DEVELOPMENT) {
            return '<script type="module" src="' . $this->baseUrl . $this->entrypoint . '"></script>';
        }
        return $this->parseScripts();
    }

    public function loadStyles(): string
    {
        $this->assertEntrypointLoaded();
        if ($this->config->appEnv === AppEnv::DEVELOPMENT) {
            return '';
        }
        return $this->parseStyles();
    }

    public function loadEntryPoint(string $entrypoint): void
    {
        $this->entrypoint = $entrypoint;
        if ($this->config->appEnv === AppEnv::DEVELOPMENT) {
            return;
        }
        $manifestFile = $this->config->publicDir . '/dist/manifest.json';
        if (!file_exists($manifestFile)) {
            throw new EntrypointResolverException('Cannot find manifest file');
        }
        $this->manifest = json_decode(file_get_contents($manifestFile));
        $this->assertValidEntrypoint();
        $this->manifestAssets($entrypoint);
    }

    private function manifestAssets(string $chunkName): void
    {
        if (!isset($this->manifest, $chunkName)) {
            throw new EntrypointResolverException("Cannot find chunk: $chunkName in manifest");
        }
        $chunk = $this->manifest->{$chunkName};

        if (isset($chunk->imports)) {
            foreach ($chunk->imports as $importChunk) {
                $this->manifestAssets($importChunk);
            }
        }

        if (isset($chunk->css)) {
            foreach ($chunk->css as $css) {
                $this->styles[] = $css;
            }
        }
        $this->scripts[] = $chunk->file;
    }

    private function parseScripts(): string
    {
        $output = '';
        foreach ($this->scripts as $script) {
            $output .= '<script type="module" src="/dist/' . $script . '"></script>' . PHP_EOL;
        }
        return $output;
    }

    private function parseStyles(): string
    {
        $output = '';
        foreach ($this->styles as $stylesheet) {
            $output .= '<link rel="stylesheet" href="/dist/' . $stylesheet . '"/>' . PHP_EOL;
        }
        return $output;
    }

    private function assertValidEntrypoint(): void
    {
        if (!isset($this->manifest->{$this->entrypoint})) {
            throw new EntrypointResolverException("Cannot find entrypoint: {$this->entrypoint} in manifest");
        }
        if (
            !isset($this->manifest->{$this->entrypoint}->isEntry) ||
            $this->manifest->{$this->entrypoint}->isEntry !== true
        ) {
            throw new EntrypointResolverException("{$this->entrypoint} is not a valid entrypoint");
        }
    }

    private function assertEntrypointLoaded(): void
    {
        if ($this->entrypoint === null) {
            throw new EntrypointResolverException('No entrypoint is loaded.');
        }
    }
}
