<?php

declare(strict_types=1);

use League\Event\EventDispatcher;
use Psr\Container\ContainerInterface;
use Timo\Cms\Cli\Commands\CreateUserCommand;
use Timo\Cms\Cli\Commands\ListUsersCommand;
use Timo\Cms\Cli\Commands\ReinstallDatabaseCommand;
use Timo\Cms\Cli\Commands\TestCommand;
use Timo\Cms\Controllers\AuthController;
use Timo\Cms\Controllers\PageController;
use Timo\Cms\Util\DatabaseInstall;

return function (EventDispatcher $e, ContainerInterface $c) {
    $e->subscribeTo(TestCommand::class, function (TestCommand $command) use ($c) {
        $c->get(PageController::class)->cli($command);
    });
    $e->subscribeTo(ListUsersCommand::class, function (ListUsersCommand $command) use ($c) {
        $c->get(AuthController::class)->listUsers();
    });
    $e->subscribeTo(CreateUserCommand::class, function (CreateUserCommand $command) use ($c) {
        $c->get(AuthController::class)->createUser($command);
    });
    $e->subscribeTo(ReinstallDatabaseCommand::class, function (ReinstallDatabaseCommand $command) use ($c) {
        $c->get(DatabaseInstall::class)->reinstall();
    });
};
