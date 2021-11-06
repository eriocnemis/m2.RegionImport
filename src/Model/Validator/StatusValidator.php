<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model\Validator;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Eriocnemis\RegionImport\Model\ValidatorInterface;

/**
 * Status validator
 */
class StatusValidator implements ValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * Status options
     *
     * @var string[]
     */
    private $options = ['0', '1'];

    /**
     * Initialize validator
     *
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory
    ) {
        $this->validationResultFactory = $validationResultFactory;
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
        if (isset($rowData['status'])) {
            $status = $rowData['status'];
            if (!isset($this->options[$status])) {
                $errors[] = __('Invalid value of %1 provided for the region status field.', $status);
            }
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
