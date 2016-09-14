<?php

namespace app;

use app\Middlewares\AuthMiddleware;
use app\Middlewares\AdminMiddleware;

class Route
{
    public function __invoke()
    {
        global $app;

        $app->get('/', 'app\Controllers\ArticleController:index');

        $app->group('/auth', function () {
            $this->get('/logout', 'app\Controllers\AuthController:logout');
            $this->get('/login', 'app\Controllers\AuthController:login');
            $this->post('/login', 'app\Controllers\AuthController:loginCheck');
        });

        $app->group('/article', function () {
            $this->get('', 'app\Controllers\ArticleController:index');
            $this->get('/{id:[0-9]+}', 'app\Controllers\ArticleController:show');
            $this->get('/classes', 'app\Controllers\ArticleController:showClasses');
        });
        $app->group('/article', function () {
            $this->post('', 'app\Controllers\ArticleController:store');
            $this->get('/create', 'app\Controllers\ArticleController:create');
        })->add(new AuthMiddleware);
        $app->group('/article/{id:[0-9]+}', function () {
            $this->get('/edit', 'app\Controllers\ArticleController:edit');
            $this->post('/update', 'app\Controllers\ArticleController:update');
            $this->get('/destroy', 'app\Controllers\ArticleController:destroy');
        })->add(new AuthMiddleware);
        $app->group('/article/sticky', function () {
            $this->get('/edit', 'app\Controllers\ArticleController:editSticky');
            $this->post('/update', 'app\Controllers\ArticleController:updateSticky');
        })->add(new AdminMiddleware)->add(new AuthMiddleware);
    }
}
