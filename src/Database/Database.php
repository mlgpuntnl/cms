<?php

declare(strict_types=1);

namespace Timo\Cms\Database;

use PDO;
use PDOStatement;

class Database
{
    public const DEFAULT_FETCHMODE = PDO::FETCH_OBJ;

    private PDO $conn;

    public function __construct(string $dsn, ?string $username = null, ?string $password = null)
    {
        $this->conn = new PDO($dsn, $username, $password);
    }

    public function fetch(string $query, array $parameters = []): FetchResult
    {
        $stmt = $this->prepare($query);
        $stmt->execute($parameters);
        return new FetchResult($stmt);
    }

    public function execute(string $query, array $parameters = []): bool
    {
        $stmt = $this->prepare($query);
        return $stmt->execute($parameters);
    }

    public function beginTransaction(): void
    {
        $this->conn->beginTransaction();
    }

    public function rollBack(): void
    {
        $this->conn->rollBack();
    }

    public function commit(): void
    {
        $this->conn->commit();
    }

    public function transaction(callable $transaction): void
    {
        try {
            $this->beginTransaction();
            $transaction($this);
            $this->commit();
        } catch (\Throwable $t) {
            $this->rollBack();
            throw $t;
        }
    }

    public function lastInsertId(?string $name = null): string|false
    {
        return $this->conn->lastInsertId($name);
    }

    private function prepare(string $query, array $parameters = []): PDOStatement
    {
        return $this->conn->prepare($query, $parameters);
    }
}
