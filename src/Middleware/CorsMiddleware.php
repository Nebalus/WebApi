<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Middleware;

use Nebalus\Webapi\Option\EnvData;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

class CorsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly App $app,
        private readonly EnvData $env
    ) {
    }

    #[Override] public function process(Request $request, RequestHandler $handler): Response
    {
        if ($request->getMethod() === 'OPTIONS') {
            return $this->addCorsHeaders($this->app->getResponseFactory()->createResponse());
        }

        $this->addCorsHeaders($handler->handle($request));
    }

    private function addCorsHeaders(Response $slimResponse): Response
    {
        $slimResponse
            ->withHeader('Access-Control-Allow-Origin', $this->env->getAccessControlAllowOrigin())
            ->withHeader('Access-Control-Allow-Methods', 'Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
    }
}
