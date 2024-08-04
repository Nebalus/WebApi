<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Service\User;

use Nebalus\Webapi\Repository\MySqlUserRepository;
use Nebalus\Webapi\Repository\MySqlReferralRepository;

class UserAuthService
{
    private MySqlUserRepository $mySqlUserRepository;
    public function __construct(
        MySqlUserRepository $mySqlUserRepository,
    ) {
        $this->mySqlUserRepository = $mySqlUserRepository;
    }

    public function authenticateUser(): void
    {
        $this->mySqlUserRepository->getUserFromId(1);
    }
}
