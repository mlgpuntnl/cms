<?php

declare(strict_types=1);

namespace Timo\Cms\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Timo\Cms\Cli\Commands\TestCommand;

class PageController extends AbstractController
{
    public function home(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $response->getBody()->write(
            $this->templates->render('frontend/main')
        );
        return $response;
    }

    public function adminPage(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $response->getBody()->write(
            $this->templates->render('admin/page')
        );
        return $response;
    }

    public function cli(TestCommand $c)
    {
        echo "Got name: " . $c->name;
    }
}
