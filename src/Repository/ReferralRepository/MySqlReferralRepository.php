<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository\ReferralRepository;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\ID;
use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Referral\ReferralCode;
use Nebalus\Webapi\Value\Referral\ReferralId;
use Nebalus\Webapi\Value\Referral\ReferralName;
use Nebalus\Webapi\Value\Referral\ReferralPointer;
use Nebalus\Webapi\Value\Referral\Referrals;
use Nebalus\Webapi\Value\User\UserId;
use PDO;

readonly class MySqlReferralRepository
{
    public function __construct(
        private PDO $pdo,
        private RedisReferralCachingRepository $redis
    ) {
    }

    public function insertReferral(ReferralId $userId, ReferralCode $code, ReferralPointer $pointer, ReferralName $name, bool $disabled = true): bool
    {
        $sql = "INSERT INTO referrals(user_id, code, pointer, name, disabled) VALUES (:user_id, :code, :pointer, :name, :disabled)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId->asInt());
        $stmt->bindValue(':code', $code->asString());
        $stmt->bindValue(':pointer', $pointer->asString());
        $stmt->bindValue(':name', $name->asString());
        $stmt->bindValue(':disabled', $disabled);
        return $stmt->execute();
    }

    public function insertReferralClickEntry(ReferralId $referralId): bool
    {
        $sql = "INSERT INTO referral_clicks(referral_id) VALUES (:referral_id)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':referral_id', $referralId->asInt());
        return $stmt->execute();
    }

    public function deleteReferralById(ReferralId $referralId): bool
    {
        $sql = "DELETE FROM referrals WHERE referral_id = :referral_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':referral_id', $referralId->asInt());
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function deleteReferralByCode(ReferralCode $code): bool
    {
        $sql = "DELETE FROM referrals WHERE code = :code";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':code', $code->asString());
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function updateReferral()
    {
    }

    /**
     * @throws ApiException
     */
    public function getReferralsFromUserId(UserId $userId): Referrals
    {
        $sql = "SELECT * FROM referrals WHERE user_id = :user_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId->asInt());
        $stmt->execute();

        $data = [];

        while ($row = $stmt->fetch()) {
            $data[] = Referral::fromArray($row);
        }

        return Referrals::fromArray(...$data);
    }

    /**
     * @throws ApiException
     */
    public function findReferralById(ReferralId $id): ?Referral
    {
        $sql = "SELECT * FROM referrals WHERE referral_id = :referral_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':referral_id', $id->asInt());
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return Referral::fromArray($data);
    }

    /**
     * @throws ApiException
     */
    public function findReferralByCode(ReferralCode $code): ?Referral
    {
        $sql = "SELECT * FROM referrals WHERE BINARY code = :code";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':code', $code->asString());
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return Referral::fromArray($data);
    }
}
