<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Save label interface
 *
 * @api
 */
interface SaveLabelInterface
{
    /**
     * Save label
     *
     * @param mixed[] $rowData
     * @param int $regionId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $rowData, $regionId): void;
}
