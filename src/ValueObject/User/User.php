<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\User;

use DateTimeImmutable;

class User
{

    private function __construct(
        private readonly int $userId,
        private readonly DateTimeImmutable $creationDate,
        private readonly string $username
    ) {
    }

    public static function from(int $userId, DateTimeImmutable $creationDate, string $username): self
    {
        return new User($userId, $creationDate, $username);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function isAdmin(): bool
    {
        return true;
    }

    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }
}
