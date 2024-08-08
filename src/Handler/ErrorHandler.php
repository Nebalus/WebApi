<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Handler;

use JsonException;
use Monolog\Logger;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;

class ErrorHandler implements ErrorHandlerInterface
{
    public function __construct(
        private readonly App $app,
        private readonly Logger $errorLogger
    ) {
    }

    /**
     * @throws JsonException
     */
    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $errorMessage = "Something went wrong... please contact an admin!";
        $statusCode = 500;

        $exceptionsToHandle = [
          ApiException::class,
          HttpNotFoundException::class,
          HttpMethodNotAllowedException::class
        ];
        $isAnExceptionToLog = true;

        foreach ($exceptionsToHandle as $exceptionToHandle) {
            if ($exception instanceof $exceptionToHandle) {
                $errorMessage = $exception->getMessage();
                $statusCode = $exception->getCode();
                $isAnExceptionToLog = false;
                break;
            }
        }

        if ($isAnExceptionToLog) {
            $this->errorLogger->error($exception);
        }

        $apiResponse = ApiResponse::fromError($errorMessage, $statusCode);
        $slimResponse = $this->app->getResponseFactory()->createResponse();
        $slimResponse->getBody()->write($apiResponse->getPayloadAsJson());
        return $slimResponse->withStatus($statusCode);
    }
}
