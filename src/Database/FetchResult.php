<?php

declare(strict_types=1);

namespace Timo\Cms\Database;

use PDO;
use PDOStatement;

class FetchResult
{
    public function __construct(private PDOStatement $stmt)
    {
    }

    public function toObject(?string $entityClassName = 'stdClass'): object|false
    {
        return $this->stmt->fetchObject($entityClassName);
    }

    public function toObjects(?string $entityClassName = 'stdClass'): array
    {
        return $this->stmt->fetchAll(PDO::FETCH_CLASS, $entityClassName);
    }

    public function toArray(): array
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function toArrays(): array
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
