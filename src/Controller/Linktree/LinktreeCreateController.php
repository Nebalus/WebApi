<?php

namespace Nebalus\Webapi\Controller\Linktree;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LinktreeCreateController
{
    public function __construct()
    {
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Linktree Api Create");

        return $response->withStatus(200);
    }
}