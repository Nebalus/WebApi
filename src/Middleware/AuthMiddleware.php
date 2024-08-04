<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Middleware;

use DateTimeImmutable;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\JwtPayload;
use Nebalus\Webapi\ValueObject\User\User;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReallySimpleJWT\Token;
use Slim\App;

class AuthMiddleware implements MiddlewareInterface
{
    private App $app;
    private EnvData $env;

    public function __construct(
        App $app,
        EnvData $env
    ) {
        $this->app = $app;
        $this->env = $env;
    }

    #[Override] public function process(Request $request, RequestHandler $handler): Response
    {
        if ($request->hasHeader("Authorization") === false) {
            return $this->abort("The 'Authorization' header is not provided", 401);
        }

        $jwt = $request->getHeader("Authorization")[0];

        if (empty($jwt)) {
            return $this->abort("The JWT provided in the 'Authorization' header is empty", 401);
        }

        if (Token::validate($jwt, $this->env->getJwtSecret()) === false) {
            return $this->abort("The JWT provided is not valid", 401);
        }

        if (Token::validateExpiration($jwt) === false) {
            return $this->abort("The JWT provided has expired", 401);
        }

        $jwtPayloadArray = Token::getPayload($jwt);
        $jwtPayload = JwtPayload::fromArray($jwtPayloadArray);

        $request = $request->withAttribute("authenticated_jwt", $jwtPayload);
        $request = $request->withAttribute("authenticated_user", User::from(42, new DateTimeImmutable(), "testuser"));

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
