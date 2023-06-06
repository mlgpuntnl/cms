<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use League\Event\EventDispatcher;
use League\Plates\Engine;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Timo\Cms\Cli\CliHandler;
use Timo\Cms\Cli\CommandProvider;
use Timo\Cms\Controllers\AuthController;
use Timo\Cms\Controllers\PageController;
use Timo\Cms\Enums\AppEnv;
use Timo\Cms\Extensions\Plates\EntrypointResolver;
use Timo\Cms\Models\AuthModel;
use Timo\Cms\Util\Config;
use Timo\Cms\Util\Database;
use Timo\Cms\Util\DatabaseInstall;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Config::class => function (ContainerInterface $c) {
        return new Config(
            dirname(__DIR__) . '/templates',
            dirname(__DIR__) . '/public',
            AppEnv::from($_ENV['APP_ENV'])
        );
    },
    CommandProvider::class => function (ContainerInterface $c) {
        $commandProvider = new CommandProvider();
        (require __DIR__ . '/commands.php')($commandProvider);
        return $commandProvider;
    },
    EventDispatcherInterface::class => function (ContainerInterface $c) {
        $e = new EventDispatcher();
        (require __DIR__ . '/events.php')($e, $c);
        return $e;
    },
    DatabaseInstall::class => function (ContainerInterface $c) {
        return new DatabaseInstall($c->get(Database::class), (require __DIR__ . '/models.php'));
    },
    CliHandler::class => function (ContainerInterface $c) {
        return new CliHandler($c->get(CommandProvider::class), $c->get(EventDispatcherInterface::class));
    },
    Database::class => function (ContainerInterface $c) {
        return new Database("{$_ENV['DB_DRIVER']}:host={$_ENV['DB_HOSTNAME']};
            port={$_ENV['DB_PORT']};
            dbname={$_ENV['DB_NAME']};
            user={$_ENV['DB_USER_NAME']};
            password={$_ENV['DB_USER_PASSWORD']}
        ");
    },
    EntrypointResolver::class => function (ContainerInterface $c) {
        return new EntrypointResolver(
            $c->get(Config::class)
        );
    },
    Engine::class => function (ContainerInterface $c) {
        $engine = new Engine($c->get(Config::class)->templatesDir);
        $engine->loadExtension($c->get(EntrypointResolver::class));
        return $engine;
    },
    AuthModel::class => function (ContainerInterface $c) {
        return new AuthModel($c->get(Database::class));
    },
    PageController::class => function (ContainerInterface $c) {
        return new PageController($c->get(Engine::class));
    },
    AuthController::class => function (ContainerInterface $c) {
        return new AuthController($c->get(AuthModel::class), $c->get(Engine::class));
    }
]);

return $containerBuilder->build();
