<?php

declare(strict_types=1);

namespace Timo\Cms\Controllers;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use stdClass;

abstract class AbstractController
{
    public function __construct(
        protected Engine $templates
    ) {
    }

    protected function createResponse(): ResponseInterface
    {
        return new Response();
    }

    protected function renderPage(string $template, array $data = []): ResponseInterface
    {
        $response = $this->createResponse();
        $response->getBody()->write(
            $this->templates->render($template, $data)
        );
        return $response->withHeader('Content-Type', 'text/html');
    }

    protected function toJson(array|stdClass $data, int $status = 200): ResponseInterface
    {
        $response = $this->createResponse();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
