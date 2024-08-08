<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Factory;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Nebalus\Webapi\Option\EnvData;

class LoggerFactory
{
    public function __construct(
        private readonly EnvData $env
    ) {
    }

    public function build(): Logger
    {
        $errorLogStream = new StreamHandler(__DIR__ . '/../../logs/error.log', $this->env->getLogLevel());
        $errorLogStream->setFormatter(new JsonFormatter());

        $logger = new Logger("ErrorLogger");
        $logger->pushHandler($errorLogStream);

        return $logger;
    }
}
