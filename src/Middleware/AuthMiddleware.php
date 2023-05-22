<?php

declare(strict_types=1);

namespace Timo\Cms\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $response = (new ResponseFactory())->createResponse(StatusCodeInterface::STATUS_FOUND, 'Needs login');
            return $response->withHeader('Location', '/admin/login/');
        }
        return $handler->handle($request);
    }
}
