<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model\Validator;

use Magento\Framework\Stdlib\StringUtils;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Eriocnemis\RegionImport\Model\ValidatorInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Check that country is valid
 */
class CountryValidator implements ValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var StringUtils
     */
    private $string;

    /**
     * @var CountryInformationAcquirerInterface
     */
    private $repository;

    /**
     * Initialize validator
     *
     * @param CountryInformationAcquirerInterface $repository
     * @param ValidationResultFactory $validationResultFactory
     * @param StringUtils $string
     */
    public function __construct(
        CountryInformationAcquirerInterface $repository,
        ValidationResultFactory $validationResultFactory,
        StringUtils $string
    ) {
        $this->repository = $repository;
        $this->validationResultFactory = $validationResultFactory;
        $this->string = $string;
    }

    /**
     * Validate data row
     *
     * @param mixed[] $rowData
     * @return ValidationResult
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function validate(array $rowData): ValidationResult
    {
        $errors = [];
        $value = $rowData[RegionInterface::COUNTRY_ID] ?? '';
        $value = $this->string->cleanString($value);

        if ('' === $value) {
            $errors[] = __('Country field is required.');
        } else {
            try {
                $this->repository->getCountryInfo($value);
            } catch (\Exception $e) {
                $errors[] = __('Invalid value of %1 provided for the country field.', $value);
            }
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
