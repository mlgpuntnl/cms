<?php

declare(strict_types=1);

namespace Timo\Cms\Cli\Commands;

use Timo\Cms\Cli\Command;

class CreateUserCommand extends Command
{
    public string $name;
    public string $password;
    public string $level = 'user';

    public function initOptions()
    {
        $this->options->add('n|name:', 'The username of the user')
            ->isa('string');
        $this->options->add('p|password:', 'The password of the user')
            ->isa('string');
        $this->options->add('l|level?', 'The user level of the user')
            ->isa('string')
            ->validValues(['user', 'admin']);
    }
}
