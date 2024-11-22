<?php

namespace Nebalus\Webapi\Api\Filter;

abstract class AbstractFilter implements FilterInterface
{
    protected string $errorMessage;
    protected array $filteredData;

    public function __construct($dataFormat)
    {
        $this->filteredData = [];
        $this->errorMessage = '';
    }

    abstract public function filterAndCheckIfStructureIsValid(array $params): bool;

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getFilteredData(): array
    {
        return $this->filteredData;
    }

    protected function checkIfAnyRequiredParamsAreMissing(array $requiredParams = [], array $providedParams = []): bool
    {
        $missingParams = $this->getMissingParams($requiredParams, $providedParams);
        if (empty($missingParams) === false) {
            $this->errorMessage = 'Missing required parameters: ' . implode(', ', $missingParams);
            return true;
        }
        return false;
    }

    private function getMissingParams(array $requiredParams = [], array $providedParams = []): array
    {
        $missingParams = [];
        foreach ($requiredParams as $requiredParam) {
            if (empty($providedParams[$requiredParam])) {
                $missingParams[] = $requiredParam;
            }
        }
        return $missingParams;
    }
}
