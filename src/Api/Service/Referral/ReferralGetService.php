<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\Validator\Referral\ReferralGetValidator;
use Nebalus\Webapi\Api\View\Referral\ReferralGetView;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralGetService
{
    public function __construct(
        private readonly MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(ReferralGetValidator $validator): ResultInterface
    {
        return ReferralGetView::render();
    }
}
