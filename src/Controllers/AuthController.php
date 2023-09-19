<?php

declare(strict_types=1);

namespace Timo\Cms\Controllers;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Timo\Cms\Cli\Commands\CreateUserCommand;
use Timo\Cms\Enums\UserLevel;
use Timo\Cms\Database\Models\AuthModel;

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
        return $this->renderPage('admin/login');
    }

    public function login(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $body = $request->getParsedBody();
        if (!$body['username'] || !$body['password']) {
            return $this->toJson([ 'error' => 'Missing post fields'], 400);
        }
        $user = $this->model->getUserByName($body['username']);
        if (!$user || !password_verify($body['password'], $user->pwd)) {
            return $this->toJson([ 'error' => 'Login incorrect'], 401);
        }
        $_SESSION['logged_in'] = true;
        $_SESSION['user_level'] = $user->user_level;
        $_SESSION['username'] = $user->username;
        return $this->toJson([
            'success' => true,
            'goto' => '/admin/'
        ]);
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, self::HASHING_ALGORITHM);
    }
}
