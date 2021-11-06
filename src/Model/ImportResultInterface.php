<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model;

/**
 * Import result interface
 */
interface ImportResultInterface
{
    /**
     * Increment count of created items
     *
     * @return void
     */
    public function addCreatedItem(): void;

    /**
     * Increment count of updated items
     *
     * @return void
     */
    public function addUpdatedItem(): void;

    /**
     * Increment count of deleted items
     *
     * @return void
     */
    public function addDeletedItem(): void;

    /**
     * Retrieve count of created items
     *
     * @return int
     */
    public function getCreatedItemsCount(): int;

    /**
     * Retrieve count of updated items
     *
     * @return int
     */
    public function getUpdatedItemsCount(): int;

    /**
     * Retrieve count of deleted items
     *
     * @return int
     */
    public function getDeletedItemsCount(): int;
}
