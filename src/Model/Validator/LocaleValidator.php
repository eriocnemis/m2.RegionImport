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
use Magento\Framework\Locale\ConfigInterface;
use Eriocnemis\RegionImport\Model\ValidatorInterface;

/**
 * Locale validator
 */
class LocaleValidator implements ValidatorInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

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
     * @param ConfigInterface $config
     * @param StringUtils $string
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
        ConfigInterface $config,
        StringUtils $string
    ) {
        $this->validationResultFactory = $validationResultFactory;
        $this->config = $config;
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
        $value = $rowData['locale'] ?? '';
        $value = $this->string->cleanString($value);

        if ('' === $value) {
            $errors[] = __('Locale field is required.');
        }

        if (!in_array($value, $this->config->getAllowedLocales(), true)) {
            $errors[] = __('Invalid value of %1 provided for the locale field.', $value);
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
