<?php

namespace Nebalus\Webapi\Controller\Referral;

use Nebalus\Webapi\ValueObject\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralDeleteController
{
    private JsonResponse $httpBodyJsonResponse;

    public function __construct(JsonResponse $httpBodyJsonResponse)
    {
        $this->httpBodyJsonResponse = $httpBodyJsonResponse;
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("ReferralObject Api Delete");

        return $response->withStatus(200);
    }
}
