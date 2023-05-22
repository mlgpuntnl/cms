<?php

declare(strict_types=1);

namespace Timo\Cms\Core;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Slim\Factory\AppFactory;
use Timo\Cms\Cli\CliHandler;
use Timo\Cms\Cli\CommandProvider;
use Dotenv\Dotenv;

class Kernel
{
    private static ?self $instance = null;
    private string $projectRoot;

    private function __construct()
    {
        $this->projectRoot = $_SERVER['PWD'];
    }

    public static function create(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function run(): void
    {
        $container = $this->init();
        if ($this->isCli()) {
            $this->runCli($container);
        }
        $this->runHttp($container);
    }

    private function runHttp(ContainerInterface $container): void
    {
        AppFactory::setContainer($container);
        $app = AppFactory::create();
        (require $this->projectRoot . '/conf/routes.php')($app);
        $app->run();
    }

    private function runCli(ContainerInterface $container): void
    {
        $commandProvider = $container->get(CommandProvider::class);
        (new CliHandler($commandProvider, $container->get(EventDispatcherInterface::class)))->handle();
        echo PHP_EOL;
        exit(0);
    }

    private function init(): ContainerInterface
    {
        $dotenv = Dotenv::createImmutable($this->projectRoot);
        $dotenv->load();
        return require $this->projectRoot . '/conf/container.php';
    }

    private function isCli(): bool
    {
        return (php_sapi_name() === 'cli');
    }
}
