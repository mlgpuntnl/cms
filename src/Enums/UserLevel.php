<?php

declare(strict_types=1);

namespace Timo\Cms\Enums;

enum UserLevel: string
{
    case USER = 'user';
    case ADMIN = 'admin';
}
