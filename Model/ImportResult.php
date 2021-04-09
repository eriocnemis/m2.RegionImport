<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model;

/**
 * Import result
 */
class ImportResult implements ImportResultInterface
{
    /**
     * Count if created items
     *
     * @var int
     */
    private $countItemsCreated = 0;

    /**
     * Count if updated items
     *
     * @var int
     */
    private $countItemsUpdated = 0;

    /**
     * Count if deleted items
     *
     * @var int
     */
    private $countItemsDeleted = 0;

    /**
     * Increment count of created items
     *
     * @return void
     */
    public function addCreatedItem(): void
    {
        $this->countItemsCreated++;
    }

    /**
     * Increment count of updated items
     *
     * @return void
     */
    public function addUpdatedItem(): void
    {
        $this->countItemsUpdated++;
    }

    /**
     * Increment count of deleted items
     *
     * @return void
     */
    public function addDeletedItem(): void
    {
        $this->countItemsDeleted++;
    }

    /**
     * Retrieve count of created items
     *
     * @return int
     */
    public function getCreatedItemsCount(): int
    {
        return $this->countItemsCreated;
    }

    /**
     * Retrieve count of updated items
     *
     * @return int
     */
    public function getUpdatedItemsCount(): int
    {
        return $this->countItemsUpdated;
    }

    /**
     * Retrieve count of deleted items
     *
     * @return int
     */
    public function getDeletedItemsCount(): int
    {
        return $this->countItemsDeleted;
    }
}
