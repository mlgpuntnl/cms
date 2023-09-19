<?php

declare(strict_types=1);

namespace Timo\Cms\Database\Models;

use Timo\Cms\Database\Database;

abstract class AbstractModel
{
    public function __construct(protected Database $db)
    {
    }

    /**
     * Generates an SQL statement to create a table for this model
     *
     * @return string The generated SQL statement
     */
    abstract public static function createTable(): string|array;

    /**
     * Generates an SQL statement to drop the table for this model
     *
     * @return string The generated SQL statement
     */
    abstract public static function dropTable(): string|array;

    public function seed(): void
    {
    }
}
