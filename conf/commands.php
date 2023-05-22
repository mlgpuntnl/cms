<?php

use Timo\Cms\Cli\CommandProvider;
use Timo\Cms\Cli\Commands\CreateUserCommand;
use Timo\Cms\Cli\Commands\ListUsersCommand;
use Timo\Cms\Cli\Commands\ReinstallDatabaseCommand;
use Timo\Cms\Cli\Commands\TestCommand;

return function (CommandProvider $commandProvider) {
    $commandProvider->register('test', TestCommand::class);
    $commandProvider->register('list-users', ListUsersCommand::class);
    $commandProvider->register('create-user', CreateUserCommand::class);
    $commandProvider->register('database-reinstall', ReinstallDatabaseCommand::class);
};
