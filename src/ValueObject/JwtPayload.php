<?php

namespace Nebalus\Webapi\ValueObject;

class JwtPayload
{
    private function __construct(
        private readonly int $userId,
        private readonly bool $isAdmin,
        private readonly string $issuer,
        private readonly int $expiresAtTimestamp,
        private readonly int $issuedAtTimestamp
    ) {
    }

    public static function fromArray(array $payload): self
    {
        $userId = $payload['user_id'];
        $isAdmin = $payload['is_admin'];
        $issuer = $payload['iss'];
        $expiresAtTimestamp = $payload['exp'];
        $issuedAtTimestamp = $payload['iat'];

        return new self($userId, $isAdmin, $issuer, $expiresAtTimestamp, $issuedAtTimestamp);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function getIssuer(): string
    {
        return $this->issuer;
    }

    public function getExpiresAtTimestamp(): int
    {
        return $this->expiresAtTimestamp;
    }

    public function getIssuedAtTimestamp(): int
    {
        return $this->issuedAtTimestamp;
    }
}
