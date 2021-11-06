<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model;

use Magento\Framework\Exception\LocalizedException;

/**
 * Behavior handlers pool interface
 */
interface HandlerPoolInterface
{
    /**
     * Retrieve handler for specific behavior
     *
     * @param string $behavior
     * @return HandlerInterface
     * @throws LocalizedException
     */
    public function get($behavior);
}
