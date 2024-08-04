<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\ApiResponse;

use JsonException;

interface ApiResponseInterface
{
    /**
     * @throws JsonException
     */
    public function getPayloadAsJson(): string;
    public function getStatusCode(): int;
    public function isSuccessful(): bool;
}
