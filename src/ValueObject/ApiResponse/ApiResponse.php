<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\ApiResponse;

use InvalidArgumentException;
use JsonException;

class ApiResponse implements ApiResponseInterface
{
    private array $payload;
    private int $statusCode;
    private bool $successful;

    private function __construct(array $payload, int $statusCode, bool $successful)
    {
        $this->payload = $payload;
        $this->statusCode = $statusCode;
        $this->successful = $successful;
    }

    protected static function fromPayload(array $payload, int $statusCode, bool $successful): static
    {
        if ($statusCode < 100 || $statusCode > 599) {
            throw new InvalidArgumentException("Code '$statusCode' is not a valid http status code!", 500);
        }

        $payload = array_merge(['successful' => $successful], $payload);

        return new static($payload, $statusCode, $successful);
    }

    public static function fromError(string $errorMessage, int $statusCode): self
    {
        $payload = ['error_message' => $errorMessage];
        return self::fromPayload($payload, $statusCode, false);
    }

    public static function fromSuccess(array $payload, int $statusCode): self
    {
        return self::fromPayload($payload, $statusCode, true);
    }

    /**
     * @throws JsonException
     */
    public function getPayloadAsJson(): string
    {
        return json_encode($this->payload, JSON_THROW_ON_ERROR | JSON_NUMERIC_CHECK);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function isSuccessful(): bool
    {
        return $this->successful;
    }
}
