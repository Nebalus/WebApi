<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateTime;
use DateTimeImmutable;
use Exception;
use Nebalus\Webapi\ValueObject\User\User;
use PDO;

class MySqlUserRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    /**
     * @throws Exception
     */
    public function getUserFromId(int $userId): User
    {
        $sql = <<<SQL
            SELECT `user_id`, `creation_date`, `username`
            FROM `users`
            WHERE `user_id` = :user_id
        SQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $userId
        ]);

        $values = $stmt->fetch(PDO::FETCH_ASSOC);
        $creationDate = new DateTimeImmutable($values["creation_date"]);

        return User::from($values["user_id"], $creationDate, $values["username"]);
    }
}
