<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Behavior validator chain
 */
class Validator implements ValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var ValidatorInterface[]
     */
    private $validators = [];

    /**
     * Initialize validator
     *
     * @param ValidationResultFactory $validationResultFactory
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
        array $validators = []
    ) {
        foreach ($validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new LocalizedException(
                    __('Validator must implement %1.', ValidatorInterface::class)
                );
            }
        }

        $this->validationResultFactory = $validationResultFactory;
        $this->validators = $validators;
    }

    /**
     * Validate data row
     *
     * @param mixed[] $rowData
     * @return ValidationResult
     */
    public function validate(array $rowData): ValidationResult
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            $result = $validator->validate($rowData);
            if (!$result->isValid()) {
                array_push($errors, ...$result->getErrors());
            }
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
