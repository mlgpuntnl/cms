<?php

declare(strict_types=1);

namespace Timo\Cms\Cli;

use GetOptionKit\OptionCollection;
use GetOptionKit\OptionParser;

abstract class Command
{
    /**
     * A collection of options for this command.
     * Specify these options in the initOptions() method
     *
     * @var OptionCollection $options
     */
    protected OptionCollection $options;

    public function __construct()
    {
        $this->options = new OptionCollection();
    }

    /**
     * This method should be overriden to define options for a command
     * @see https://github.com/c9s/GetOptionKit/wiki/Defining-Options
     *
     * @return void
     */
    public function initOptions()
    {
    }

    /**
     * Decorates this command's properties with te provided arguments
     *
     * @param array $arguments the arguments to decorate with
     * @return self
     */
    final public function decorateCommand(array $arguments): self
    {
        $commandArguments = $this->getCommandArguents($arguments);
        foreach ($commandArguments as $key => $value) {
            $property = lcfirst(str_replace('-', '', ucwords($key, '-')));
            $this->{$property} = $value;
        }
        return $this;
    }

    private function getCommandArguents(array $arguments): array
    {
        return (new OptionParser($this->options))->parse($arguments)->toArray();
    }
}
