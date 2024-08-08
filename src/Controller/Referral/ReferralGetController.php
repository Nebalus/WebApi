<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Controller\Referral;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Service\Referral\ReferralGetService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralGetController
{
    public function __construct(
        private readonly ReferralGetService $referralGetService,
    ) {
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        try {
            // Gets Params
            if (array_key_exists("code", $args)) {
                $code = $args["code"];
            } else {
                throw new ApiException("There is no code to process", 400);
            }

            $apiResponse = $this->referralGetService->action($code);
        } catch (ApiException $e) {
            $apiResponse = ApiErrorResponse::from($e->getMessage(), $e->getCode());
        }

        $response->getBody()->write($apiResponse->getPayloadAsJson());

        return $response->withStatus($apiResponse->getStatusCode());
    }
}
