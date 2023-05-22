<?php

declare(strict_types=1);

namespace Timo\Cms\Controllers;

use League\Plates\Engine;

abstract class AbstractController
{
    public function __construct(
        protected Engine $templates
    ) {
    }
}
