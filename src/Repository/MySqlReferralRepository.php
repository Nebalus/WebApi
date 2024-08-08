<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateTime;
use Exception;
use Nebalus\Webapi\ValueObject\User\User;
use Nebalus\Webapi\ValueObject\Referral\Referral;
use PDO;

class MySqlReferralRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function createReferral(string $code, string $pointer)
    {
    }

    public function deleteReferralById(int $id)
    {
    }

    public function deleteReferralByCode(string $code)
    {
    }

    public function updateReferral()
    {
    }

    public function getReferralById(int $id)
    {
    }

    public function setViewCountByCode(string $code, int $viewCount): bool
    {
        $sql = "UPDATE `referrals` SET `view_count`=:view_count WHERE BINARY `code`=:code";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            "code" => $code,
            "view_count" => $viewCount
        ]);
    }

    public function getReferralByCode(string $code): Referral|false
    {
        $sql = "SELECT `referral_id`, `user_id`, `code`, `pointer`, `view_count`, `creation_date`, `enabled` FROM `referrals` WHERE BINARY `code` = :code";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "code" => $code
        ]);

        if ($entry = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $creationDate = new DateTime($entry["creation_date"]);
            return Referral::from($entry["referral_id"], $entry["user_id"], $entry["code"], $entry["pointer"], $entry["view_count"], $creationDate, $entry["enabled"]);
        }
        return false;
    }
}
