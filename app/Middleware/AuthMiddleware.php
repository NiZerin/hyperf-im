<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Src\Home\service\Auth;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    public function __construct(HttpResponse $response, RequestInterface $request)
    {
        $this->response = $response;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeader('Authorization')[0] ?? '';

        if (empty($token)) {
            return $this->response->json(data('token is lost'));
        }

        $check = (new Auth())->checkToken($token);

        if (is_bool($check)) {
            return $this->response->json(data('token check failed'));
        } else {
            $request = Context::get(ServerRequestInterface::class);

            $request = $request->withAttribute('user', $check);

            Context::set(ServerRequestInterface::class, $request);

            return $handler->handle($request);
        }
    }
}