<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\RegionImport\Api\GetRegionIdInterface;

/**
 * Get region id
 */
class GetRegionId implements GetRegionIdInterface
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
     * Retrieve region id
     *
     * @param mixed[] $rowData
     * @return int|null
     * @throws LocalizedException
     */
    public function execute(array $rowData): ?int
    {
        try {
            $connection = $this->resource->getConnection();
            $select = $connection->select()->from(
                $this->resource->getTableName(self::TABLE_NAME),
                ['region_id']
            )
            ->where('country_id = ?', (string)$rowData['country_id'])
            ->where('code = ?', (string)$rowData['code']);

            $result = $connection->fetchOne($select);
            if ($result) {
                return (int)$result;
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new LocalizedException(
                __('Region with specified code and specified country not found.')
            );
        }
        return null;
    }
}
