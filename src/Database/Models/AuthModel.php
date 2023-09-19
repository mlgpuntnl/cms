<?php

declare(strict_types=1);

namespace Timo\Cms\Database\Models;

use Timo\Cms\Enums\UserLevel;

class AuthModel extends AbstractModel
{
    public static function createTable(): string|array
    {
        return [
            "CREATE TYPE auth_level AS ENUM('user', 'admin');",
            "CREATE TABLE IF NOT EXISTS auth (
                id SERIAL PRIMARY KEY,
                username CHARACTER VARYING(255),
                pwd CHARACTER VARYING(255),
                user_level auth_level
            );"
        ];
    }

    public static function dropTable(): string|array
    {
        return [
            "DROP TABLE IF EXISTS auth",
            "DROP TYPE IF EXISTS auth_level",
        ];
    }

    public function createUser(string $userName, string $passwordHash, UserLevel $userLevel): int
    {
        $this->db->execute(
            'INSERT INTO auth (username, pwd, user_level) VALUES (:username, :pwd, :user_level)',
            [
                ':username' => $userName,
                ':pwd' => $passwordHash,
                ':user_level' => $userLevel->value
            ]
        );
        return (int) $this->db->lastInsertId();
    }

    public function getUserByName(string $userName)
    {
        return $this->db->fetch(
            'SELECT * FROM auth WHERE username=:username',
            [ ':username' => $userName ]
        );
    }

    public function getAllUsers(): array
    {
        return $this->db->fetchAll(
            'SELECT id, username, user_level FROM auth'
        );
    }
}
