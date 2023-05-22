<?php

declare(strict_types=1);

namespace Timo\Cms\Cli;

use Psr\EventDispatcher\EventDispatcherInterface;
use RuntimeException;

class CliHandler
{
    private array $args;

    public function __construct(
        private CommandProvider $commandProvider,
        private EventDispatcherInterface $eventDispatcher
    ) {
        $this->args = $_SERVER['argv'];
    }

    public function handle()
    {
        $commandName = $this->args[1];
        if (!$this->commandProvider->has($commandName)) {
            throw new RuntimeException('Unknown command: ' . $commandName);
        }
        $commandClassname = $this->commandProvider->get($commandName);
        $command = new $commandClassname();
        $command->initOptions();
        $this->eventDispatcher->dispatch($command->decorateCommand($this->args));
    }
}
