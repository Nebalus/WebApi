<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Service\User;

use Nebalus\Webapi\Repository\MySqlUserRepository;
use Nebalus\Webapi\Repository\MySqlReferralRepository;

class UserAuthService
{
    public function __construct(
        private readonly MySqlUserRepository $mySqlUserRepository,
    ) {
    }

    public function authenticateUser(): void
    {
        $this->mySqlUserRepository->getUserFromId(1);
    }
}
