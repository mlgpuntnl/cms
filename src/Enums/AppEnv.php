<?php

declare(strict_types=1);

namespace Timo\Cms\Enums;

enum AppEnv: string
{
    case DEVELOPMENT = 'development';
    case PRODUCTION = 'production';
}
