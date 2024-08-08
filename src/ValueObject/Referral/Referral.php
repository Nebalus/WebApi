<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\Referral;

use DateTime;
use DateTimeImmutable;

class Referral
{
    private function __construct(
        private readonly int $referralId,
        private readonly int $userId,
        private readonly string $code,
        private readonly string $pointer,
        private readonly int $viewCount,
        private readonly DateTimeImmutable $creationDate,
        private readonly bool $enabled
    ) {
    }

    public static function from(int $referralId, int $userId, string $code, string $pointer, int $viewCount, DateTimeImmutable $creationDate, bool $enabled): Referral
    {
        return new Referral($referralId, $userId, $code, $pointer, $viewCount, $creationDate, $enabled);
    }
    public function getReferralId(): int
    {
        return $this->referralId;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getCode(): string
    {
        return $this->code;
    }
    public function getPointer(): string
    {
        return $this->pointer;
    }
    public function getViewCount(): int
    {
        return $this->viewCount;
    }
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
