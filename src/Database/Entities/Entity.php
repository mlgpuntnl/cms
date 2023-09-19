<?php

declare(strict_types=1);

namespace Timo\Cms\Database\Entities;

use JsonSerializable;
use Timo\Cms\Database\Exceptions\InvalidEntityException;

abstract class Entity implements JsonSerializable
{
    public static string $primaryKey = 'id';
    public static string $table;

    final public function __construct()
    {
        if (!isset(static::$table)) {
            throw new InvalidEntityException('Missing table declaration for entity class: ' . static::class);
        }
    }

    public function primaryKey(): string
    {
        return static::$primaryKey;
    }

    public function table(): string
    {
        return static::$table;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
