<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\Referral;

use DateTime;
use DateTimeImmutable;

class Referral
{
    private int $referralId;
    private int $userId;
    private string $code;
    private string $pointer;
    private int $viewCount;
    private DateTimeImmutable $creationDate;
    private bool $enabled;

    private function __construct(int $referralId, int $userId, string $code, string $pointer, int $viewCount, DateTimeImmutable $creationDate, bool $enabled)
    {
        $this->referralId = $referralId;
        $this->userId = $userId;
        $this->code = $code;
        $this->pointer = $pointer;
        $this->viewCount = $viewCount;
        $this->creationDate = $creationDate;
        $this->enabled = $enabled;
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
