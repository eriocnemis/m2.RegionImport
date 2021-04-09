<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Api;

use Magento\Framework\Exception\LocalizedException;

/**
 * Get region id interface
 *
 * @api
 */
interface GetRegionIdInterface
{
    /**
     * Retrieve region id
     *
     * @param mixed[] $rowData
     * @return int|null
     * @throws LocalizedException
     */
    public function execute(array $rowData): ?int;
}
