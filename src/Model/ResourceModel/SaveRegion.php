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
use Eriocnemis\RegionImport\Api\SaveRegionInterface;

/**
 * Save region
 */
class SaveRegion implements SaveRegionInterface
{
    /**
     * Region table name
     */
    private const TABLE_NAME = 'directory_country_region';

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
     * Save region
     *
     * @param mixed[] $rowData
     * @return int|null
     * @throws CouldNotSaveException
     */
    public function execute(array $rowData): ?int
    {
        try {
            $data = $this->getRegionBind($rowData);
            if ($data) {
                $tableName = $this->resource->getTableName(self::TABLE_NAME);
                $connection = $this->resource->getConnection();
                $connection->insert($tableName, $data);
                return (int)$connection->lastInsertId($tableName);
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotSaveException(
                __('Could not save the region.')
            );
        }
        return null;
    }

    /**
     * Retrieve region bind data
     *
     * @param mixed[] $rowData
     * @return mixed[]
     */
    private function getRegionBind(array $rowData): array
    {
        $data = [
            'country_id' => $rowData['country_id'],
            'code' => $rowData['code'],
            'default_name' => $rowData['name']
        ];

        if (isset($rowData['status'])) {
            $data['status'] = (int)$rowData['status'];
        }
        return $data;
    }
}
