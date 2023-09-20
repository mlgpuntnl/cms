<?php

declare(strict_types=1);

namespace Timo\Cms\Database\Models;

use Timo\Cms\Database\Database;
use Timo\Cms\Database\Entities\Entity;

abstract class AbstractModel
{
    public function __construct(protected Database $db, public readonly string $entityClassName)
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

    public function insert(Entity $entity): bool
    {
        $primaryKey = $entity->primaryKey();
        $table = $entity->table();
        $fields = $entity->toArray();
        unset($fields[$primaryKey]);
        $columns = implode(', ', array_keys($fields));
        array_walk($fields, fn($item, &$key) => $key = ":$key", '');
        $values = implode(', ', array_keys($fields));
        return $this->db->execute(
            "INSERT INTO $table ($columns) VALUES ($values)",
            $fields
        );
    }

    public function getItem(mixed $id): Entity
    {
        $table = $this->entityClassName::$table;
        $primaryKey = $this->entityClassName::$primaryKey;
        return $this->db->fetch(
            "SELECT * FROM $table WHERE $primaryKey=:primaryKey",
            [ ':primaryKey' => $id ]
        )->toObject($this->entityClassName);
    }

    public function getAll(): array
    {
        $table = $this->entityClassName::$table;
        return $this->db->fetch("SELECT * FROM $table")->toObjects($this->entityClassName);
    }

    public function findOne(string $columnName, mixed $value): Entity
    {
        $table = $this->entityClassName::$table;
        return $this->db->fetch(
            "SELECT * FROM $table WHERE $columnName=:value",
            [ ':value' => $value ]
        )->toObject($this->entityClassName);
    }

    public function find(string $columnName, mixed $value): array
    {
        $table = $this->entityClassName::$table;
        return $this->db->fetch(
            "SELECT * FROM $table WHERE $columnName=:value",
            [ ':value' => $value ]
        )->toObjects($this->entityClassName);
    }
}
