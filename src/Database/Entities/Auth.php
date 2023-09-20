<?php

declare(strict_types=1);

namespace Timo\Cms\Database\Entities;

class Auth extends Entity
{
    public static string $table = 'auth';

    public ?int $id = null;
    public string $username;
    public string $pwd;
    public string $user_level;
}
