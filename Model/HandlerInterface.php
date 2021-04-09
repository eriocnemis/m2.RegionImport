<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model;

/**
 * Behavior handler interface
 */
interface HandlerInterface
{
    /**
     * Executes the procedure
     *
     * @param mixed[] $rowData
     * @return void
     */
    public function execute(array $rowData);

    /**
     * Retrieve the import result
     *
     * @return ImportResultInterface
     */
    public function getImportResult();
}
