<?php

declare(strict_types=1);

namespace Timo\Cms\Controllers;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Timo\Cms\Cli\Commands\CreateUserCommand;
use Timo\Cms\Enums\UserLevel;
use Timo\Cms\Models\AuthModel;

class AuthController extends AbstractController
{
    private const HASHING_ALGORITHM = PASSWORD_ARGON2I;

    public function __construct(
        private AuthModel $model,
        Engine $templates
    ) {
        parent::__construct($templates);
    }

    public function createUser(CreateUserCommand $cmd): void
    {
        $userId = $this->model->createUser(
            $cmd->name,
            $this->hashPassword($cmd->password),
            UserLevel::from($cmd->level)
        );
        echo 'Created user with id: ' . $userId;
    }

    public function listUsers(): void
    {
        $users = $this->model->getAllUsers();
        foreach ($users as $user) {
            echo "({$user->id}) - {$user->username} - [{$user->user_level}]";
        }
    }

    public function loginPage(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $response->getBody()->write(
            $this->templates->render('admin/login')
        );
        return $response;
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, self::HASHING_ALGORITHM);
    }
}
