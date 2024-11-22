<?php

namespace Nebalus\Webapi\Api\Filter\Referral\Analytics;

use Nebalus\Webapi\Api\Filter\AbstractFilter;
use Override;

class ReferralClickFilter extends AbstractFilter
{
    public function __construct()
    {
        parent::__construct([
//            "code" => fn() {},
        ]);
    }

    #[Override] public function filterAndCheckIfStructureIsValid(array $params): bool
    {
        $requiredParams = ['code'];
        if ($this->checkIfAnyRequiredParamsAreMissing($requiredParams, $params)) {
            $this->errorMessage = 'Please give a valid referral code';
            return false;
        }

        $this->filteredData = [
            'code' => $params['code'],
        ];

        return true;
    }
}
