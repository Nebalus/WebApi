<?php

namespace Nebalus\Webapi\ValueObject;

class JwtPayload
{
    private int $userId;
    private bool $isAdmin;
    private string $issuer;
    private int $expiresAtTimestamp;
    private int $issuedAtTimestamp;

    private function __construct(
        int $userId,
        bool $isAdmin,
        string $issuer,
        int $expiresAtTimestamp,
        int $issuedAtTimestamp
    ) {
        $this->userId = $userId;
        $this->isAdmin = $isAdmin;
        $this->issuer = $issuer;
        $this->expiresAtTimestamp = $expiresAtTimestamp;
        $this->issuedAtTimestamp = $issuedAtTimestamp;
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
