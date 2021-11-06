<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\StringUtils;
use Magento\ImportExport\Model\ImportFactory;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;
use Magento\ImportExport\Model\ResourceModel\Helper as ResourceHelper;

/**
 * Import context
 */
class Context
{
    /**
     * @var StringUtils
     */
    private $string;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ImportFactory
     */
    private $importFactory;

    /**
     * @var ResourceHelper
     */
    private $resourceHelper;

    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var ProcessingErrorAggregatorInterface
     */
    private $errorAggregator;

    /**
     * Initialize context
     *
     * @param StringUtils $string
     * @param ScopeConfigInterface $scopeConfig
     * @param ImportFactory $importFactory
     * @param ResourceHelper $resourceHelper
     * @param ResourceConnection $resource
     * @param ProcessingErrorAggregatorInterface $errorAggregator
     */
    public function __construct(
        StringUtils $string,
        ScopeConfigInterface $scopeConfig,
        ImportFactory $importFactory,
        ResourceHelper $resourceHelper,
        ResourceConnection $resource,
        ProcessingErrorAggregatorInterface $errorAggregator
    ) {
        $this->string = $string;
        $this->scopeConfig = $scopeConfig;
        $this->importFactory = $importFactory;
        $this->resourceHelper = $resourceHelper;
        $this->resource = $resource;
        $this->errorAggregator = $errorAggregator;
    }

    /**
     * Retrieve string lib
     *
     * @return StringUtils
     */
    public function getStringUtils()
    {
        return $this->string;
    }

    /**
     * Retrieve core store config
     *
     * @return ScopeConfigInterface
     */
    public function getScopeConfig()
    {
        return $this->scopeConfig;
    }

    /**
     * Retrieve import factory
     *
     * @return ImportFactory
     */
    public function getImportFactory()
    {
        return $this->importFactory;
    }

    /**
     * Retrieve resource helper
     *
     * @return ResourceHelper
     */
    public function getResourceHelper()
    {
        return $this->resourceHelper;
    }

    /**
     * Retrieve resource connection
     *
     * @return ResourceConnection
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Retrieve processing error aggregator
     *
     * @return ProcessingErrorAggregatorInterface
     */
    public function getErrorAggregator()
    {
        return $this->errorAggregator;
    }
}
