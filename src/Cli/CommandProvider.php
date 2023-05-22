<?php

declare(strict_types=1);

namespace Timo\Cms\Cli;

use OutOfBoundsException;

class CommandProvider
{
    /**
     * @var string[] $commands
     */
    private array $commands = [];

    public function register(string $name, string $command): void
    {
        $this->commands[$name] = $command;
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->commands);
    }

    public function get(string $name): string
    {
        if (!$this->has($name)) {
            throw new OutOfBoundsException("Command with name: '$name' does not exist");
        }
        return $this->commands[$name];
    }
}
