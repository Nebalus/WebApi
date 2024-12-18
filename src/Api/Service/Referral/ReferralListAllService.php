<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\Validator\Referral\ReferralListAllValidator;
use Nebalus\Webapi\Api\View\Referral\ReferralEditView;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralListAllService
{
    public function __construct(
        private readonly MySqlReferralRepository $referralRepository
    ) {
    }

    public function execute(ReferralListAllValidator $validator): ResultInterface
    {
        return ReferralEditView::render();
    }
}
