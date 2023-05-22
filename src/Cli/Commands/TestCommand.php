<?php

declare(strict_types=1);

namespace Timo\Cms\Cli\Commands;

use Timo\Cms\Cli\Command;

class TestCommand extends Command
{
    public string $name;

    public function initOptions()
    {
        $this->options->add('n|name:', 'A name to provide')
            ->isa('string');
    }
}
