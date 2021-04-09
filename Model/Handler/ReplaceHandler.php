<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model\Handler;

use Eriocnemis\RegionImport\Model\HandlerInterface;
use Eriocnemis\RegionImport\Model\ImportResultInterface;

/**
 * Behavior replace handler
 */
class ReplaceHandler implements HandlerInterface
{
    /**
     * @var DeleteHandler
     */
    private $deleteHandler;

    /**
     * @var AppendHandler
     */
    private $appendHandler;

    /**
     * @var ImportResultInterface
     */
    private $importResult;

    /**
     * Array of primary keys of deleted rows as keys and boolean true as values
     *
     * @var mixed[]
     */
    private $deleted = [];

    /**
     * Initialize handler
     *
     * @param DeleteHandler $deleteHandler
     * @param AppendHandler $appendHandler
     * @param ImportResultInterface $importResult
     */
    public function __construct(
        DeleteHandler $deleteHandler,
        AppendHandler $appendHandler,
        ImportResultInterface $importResult
    ) {
        $this->deleteHandler = $deleteHandler;
        $this->appendHandler = $appendHandler;
        $this->importResult = $importResult;
    }

    /**
     * Executes the procedure
     *
     * @param mixed[] $rowData
     * @return void
     */
    public function execute(array $rowData)
    {
        if (!$this->isDeleted($rowData)) {
            $this->deleteHandler->execute($rowData);
            $this->markAsDeleted($rowData);
        }
        $this->appendHandler->execute($rowData);
    }

    /**
     * Retrieve the import result
     *
     * @return ImportResultInterface
     */
    public function getImportResult()
    {
        return $this->importResult;
    }

    /**
     * Checks that the region has been deleted
     *
     * @param mixed[] $rowData
     * @return bool
     */
    private function isDeleted(array $rowData)
    {
        return isset($this->deleted[$this->getPrimaryKey($rowData)]);
    }

    /**
     * Mark as deleted
     *
     * @param mixed[] $rowData
     * @return void
     */
    private function markAsDeleted(array $rowData)
    {
        $this->deleted[$this->getPrimaryKey($rowData)] = true;
    }

    /**
     * Retrieve primary key of region
     *
     * @param mixed[] $rowData
     * @return string
     */
    private function getPrimaryKey(array $rowData)
    {
        return $rowData['country_id'] . '-' . $rowData['code'];
    }
}
