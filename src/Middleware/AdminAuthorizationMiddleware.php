<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Middleware;

use Nebalus\Webapi\Exception\ApiConfigurationError;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\User\User;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

class AdminAuthorizationMiddleware implements MiddlewareInterface
{
    private App $app;

    public function __construct(
        App $app,
    ) {
        $this->app = $app;
    }

    /**
     * @throws ApiConfigurationError
     */
    #[Override] public function process(Request $request, RequestHandler $handler): Response
    {
        $user = $request->getAttribute("authenticated_user", false);

        if ($user === false) {
            throw new ApiConfigurationError("The 'authenticated_user' attribute in the request is required");
        }

        if ($user instanceof User === false) {
            throw new ApiConfigurationError("The 'authenticated_user' attribute must be an instance of User");
        }

        if ($user->isAdmin() === false) {
            return $this->abort("Forbidden: You are not an Admin", 403);
        }

        return $handler->handle($request);
    }

    private function abort(string $errorMessage, int $code): Response
    {
        $apiResponse = ApiResponse::fromError($errorMessage, $code);
        $slimResponse = $this->app->getResponseFactory()->createResponse();
        $slimResponse->getBody()->write($apiResponse);
        return $slimResponse;
    }
}
