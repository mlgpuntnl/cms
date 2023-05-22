<?php

declare(strict_types=1);

use Timo\Cms\Core\Kernel;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = Kernel::create();
$app->run();
