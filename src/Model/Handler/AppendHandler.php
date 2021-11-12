<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model\Handler;

use Eriocnemis\RegionImport\Api\SaveLabelInterface;
use Eriocnemis\RegionImport\Api\SaveRegionInterface;
use Eriocnemis\RegionImport\Api\GetRegionIdInterface;
use Eriocnemis\RegionImport\Model\HandlerInterface;
use Eriocnemis\RegionImport\Model\ImportResultInterface;

/**
 * Behavior append handler
 */
class AppendHandler implements HandlerInterface
{
    /**
     * @var GetRegionIdInterface
     */
    private $getRegionId;

    /**
     * @var SaveRegionInterface
     */
    private $saveRegion;

    /**
     * @var SaveLabelInterface
     */
    private $saveLabel;

    /**
     * @var ImportResultInterface
     */
    private $importResult;

    /**
     * Initialize handler
     *
     * @param SaveLabelInterface $saveLabel
     * @param SaveRegionInterface $saveRegion
     * @param GetRegionIdInterface $getRegionId
     * @param ImportResultInterface $importResult
     */
    public function __construct(
        SaveLabelInterface $saveLabel,
        SaveRegionInterface $saveRegion,
        GetRegionIdInterface $getRegionId,
        ImportResultInterface $importResult
    ) {
        $this->saveLabel = $saveLabel;
        $this->saveRegion = $saveRegion;
        $this->getRegionId = $getRegionId;
        $this->importResult = $importResult;
    }

    /**
     * Executes the procedure
     *
     * @param mixed[] $rowData
     * @return void
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function execute(array $rowData)
    {
        $regionId = $this->getRegionId->execute($rowData);
        if (empty($regionId)) {
            $regionId = $this->saveRegion->execute($rowData);
            $this->importResult->addCreatedItem();
        } else {
            $this->importResult->addUpdatedItem();
        }
        $this->saveLabel->execute($rowData, (int)$regionId);
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
