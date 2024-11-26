<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\Validator\Referral\ReferralDeleteValidator;
use Nebalus\Webapi\Api\View\Referral\ReferralDeleteView;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralDeleteService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(ReferralDeleteValidator $validator): ResultInterface
    {
        return ReferralDeleteView::render();
    }
}
