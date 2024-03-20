<?php

namespace Nebalus\Webapi\Service\Account;

use Nebalus\Webapi\Repository\MySqlRepository;

class AccountLoginService
{
    private MySqlRepository $mySqlRepository;
    public function __construct(
        MySqlRepository $mySqlRepository,
    ) {
        $this->mySqlRepository = $mySqlRepository;
    }

    public function action()
    {
        $this->mySqlRepository->getAccountFromId(1);
    }
}
