<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Save region interface
 *
 * @api
 */
interface SaveRegionInterface
{
    /**
     * Save region
     *
     * @param mixed[] $rowData
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute(array $rowData): ?int;
}
