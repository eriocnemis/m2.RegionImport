<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model;

use Magento\Framework\Exception\LocalizedException;

/**
 * Behavior validator pool interface
 */
interface ValidatorPoolInterface
{
    /**
     * Retrieve validator for specific behavior
     *
     * @param string $behavior
     * @return ValidatorInterface
     * @throws LocalizedException
     */
    public function get($behavior);
}
