<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotDeleteException;
use Eriocnemis\RegionImport\Api\DeleteLabelInterface;

/**
 * Delete label
 */
class DeleteLabel implements DeleteLabelInterface
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
     * Delete label
     *
     * @param int $regionId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute($regionId): void
    {
        try {
            $this->resource->getConnection()->delete(
                $this->resource->getTableName(self::TABLE_NAME),
                ['region_id = ?' => $regionId]
            );
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotDeleteException(
                __('Could not delete the label.')
            );
        }
    }
}
