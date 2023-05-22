<?php

declare(strict_types=1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Timo\Cms\Controllers\AuthController;
use Timo\Cms\Controllers\PageController;
use Timo\Cms\Middleware\AuthMiddleware;
use Timo\Cms\Middleware\SessionMiddleware;

return function (App $app) {
    // Global middleware
    $app->add(new SessionMiddleware());
    // Routes
    $app->get('/', [PageController::class, 'home']);

    // Admin login page
    $app->get('/admin/login/', [AuthController::class, 'loginPage']);
    // Admin panel routes
    $app->group('/admin', function (RouteCollectorProxy $group) {
        $group->get('/', [PageController::class, 'adminPage']);
    })->add(new AuthMiddleware());
};
