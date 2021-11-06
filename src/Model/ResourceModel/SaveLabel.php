<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;
use Eriocnemis\RegionImport\Api\SaveLabelInterface;

/**
 * Save label
 */
class SaveLabel implements SaveLabelInterface
{
    /**
     * Label table name
     */
    private const TABLE_NAME = 'directory_country_region_name';

    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize resource
     *
     * @param ResourceConnection $resource
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResourceConnection $resource,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * Save label
     *
     * @param mixed[] $rowData
     * @param int $regionId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $rowData, $regionId): void
    {
        try {
            $data = $this->getLabelBind($rowData, $regionId);
            if ($data) {
                $this->resource->getConnection()->insertOnDuplicate(
                    $this->resource->getTableName(self::TABLE_NAME),
                    $data
                );
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotSaveException(
                __('Could not save the label.')
            );
        }
    }

    /**
     * Retrieve label bind data
     *
     * @param mixed[] $rowData
     * @param int $regionId
     * @return mixed[]
     */
    private function getLabelBind(array $rowData, $regionId)
    {
        return [
            'region_id' => $regionId,
            'locale' => $rowData['locale'],
            'name' => $rowData['name']
        ];
    }
}
