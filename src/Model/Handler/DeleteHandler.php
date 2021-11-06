<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model\Handler;

use Eriocnemis\RegionImport\Api\DeleteLabelInterface;
use Eriocnemis\RegionImport\Api\DeleteRegionInterface;
use Eriocnemis\RegionImport\Api\GetRegionIdInterface;
use Eriocnemis\RegionImport\Model\HandlerInterface;
use Eriocnemis\RegionImport\Model\ImportResultInterface;

/**
 * Behavior delete handler
 */
class DeleteHandler implements HandlerInterface
{
    /**
     * @var GetRegionIdInterface
     */
    private $getRegionId;

    /**
     * @var DeleteLabelInterface
     */
    private $deleteLabel;

    /**
     * @var DeleteRegionInterface
     */
    private $deleteRegion;

    /**
     * @var ImportResultInterface
     */
    private $importResult;

    /**
     * Initialize handler
     *
     * @param GetRegionIdInterface $getRegionId
     * @param DeleteRegionInterface $deleteRegion
     * @param DeleteLabelInterface $deleteLabel
     * @param ImportResultInterface $importResult
     */
    public function __construct(
        GetRegionIdInterface $getRegionId,
        DeleteRegionInterface $deleteRegion,
        DeleteLabelInterface $deleteLabel,
        ImportResultInterface $importResult
    ) {
        $this->getRegionId = $getRegionId;
        $this->deleteRegion = $deleteRegion;
        $this->deleteLabel = $deleteLabel;
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
        $regionId = $this->getRegionId->execute($rowData);
        if (!empty($regionId)) {
            $this->deleteLabel->execute($regionId);
            $this->deleteRegion->execute($regionId);
            $this->importResult->addDeletedItem();
        }
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
}
