<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Api;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Delete label interface
 *
 * @api
 */
interface DeleteLabelInterface
{
    /**
     * Delete label
     *
     * @param int $regionId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute($regionId): void;
}
