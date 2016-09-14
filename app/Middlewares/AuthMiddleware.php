<?php

namespace app\Middlewares;

class AuthMiddleware
{
    /**
     * Auth middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        global $container;

        $auth = new \app\Auth;
		if (!$auth->check()) {
			$response->getBody()->write($container['LeaguePlates']->render('auth/guest'));
            return $response;
		}
        return $next($request, $response);
    }
}
