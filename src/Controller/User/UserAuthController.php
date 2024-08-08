<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Controller\User;

use Nebalus\Webapi\Service\User\UserAuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserAuthController
{
    public function __construct(
        private readonly UserAuthService $userAuthService
    ) {
    }

    public function authAction(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody() ?? [];


        return $response;
    }
}
