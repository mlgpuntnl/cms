<?php

declare(strict_types=1);

namespace Timo\Cms\Extensions\Plates;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use stdClass;
use Timo\Cms\Util\Config;

class EntrypointResolver implements ExtensionInterface
{
    private ?stdClass $entrypoint = null;
    public mixed $template;

    public function __construct(private Config $config)
    {
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('load_entrypoint', [$this, 'loadEntryPoint']);
        $engine->registerFunction('load_scripts', [$this, 'loadScripts']);
        $engine->registerFunction('load_styles', [$this, 'loadStyles']);
    }

    public function loadScripts(): string
    {
        $this->asserEntrypointLoaded();
        $scripts = '';
        foreach ($this->entrypoint->js as $script) {
            $scripts .= '<script src="' . $script . '" defer></script>' . PHP_EOL;
        }
        return $scripts;
    }

    public function loadStyles(): string
    {
        $this->asserEntrypointLoaded();
        $stylesheets = '';
        foreach ($this->entrypoint->css as $stylesheet) {
            $stylesheets .= '<link rel="stylesheet" href="' . $stylesheet . '"> ' . PHP_EOL;
        }
        return $stylesheets;
    }

    public function loadEntryPoint(string $entrypoint): void
    {
        $file = $this->config->publicDir . '/build/entrypoints.json';
        if (!file_exists($file)) {
            throw new EntrypointResolverException('Cannot find entrypoints.json file');
        }
        $entrypoints = json_decode(file_get_contents($file));
        if ($entrypoints === null) {
            throw new EntrypointResolverException('Cannot parse entrypoints.json');
        }
        if (!property_exists($entrypoints->entrypoints, $entrypoint)) {
            throw new EntrypointResolverException("Cannot find entrypoint: $entrypoint");
        }
        $this->entrypoint = $entrypoints->entrypoints->{$entrypoint};
    }

    private function asserEntrypointLoaded()
    {
        if ($this->entrypoint === null) {
            throw new EntrypointResolverException('No entrypoint is loaded.');
        }
    }
}
