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
use Eriocnemis\RegionImport\Model\ValidatorInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Check that code is valid
 */
class CodeValidator implements ValidatorInterface
{
    /**
     * Max DB field length
     */
    const DB_MAX_LENGTH = 32;

    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var StringUtils
     */
    private $string;

    /**
     * Initialize validator
     *
     * @param ValidationResultFactory $validationResultFactory
     * @param StringUtils $string
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
        StringUtils $string
    ) {
        $this->validationResultFactory = $validationResultFactory;
        $this->string = $string;
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
        $value = $rowData[RegionInterface::CODE] ?? '';
        $value = $this->string->cleanString($value);

        if ('' === $value) {
            $errors[] = __('Code field is required.');
        }

        if ($this->string->strlen($value) > self::DB_MAX_LENGTH) {
            $errors[] = __('Code field exceeded max length.');
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
