<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model;

use Psr\Log\LoggerInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Exception\LocalizedException;
use Magento\ImportExport\Model\Import\AbstractEntity;
use Magento\ImportExport\Model\Import;

/**
 * Region import
 */
class Region extends AbstractEntity
{
    /**
     * Permanent entity columns
     *
     * @var string[]
     */
    protected $_permanentAttributes = [
        'country_id',
        'code'
    ];

    /**
     * Code of a primary attribute of group
     *
     * @var string
     */
    protected $masterAttributeCode = 'country_id';

    /**
     * List of available behaviors
     *
     * @var string[]
     */
    protected $_availableBehaviors = [
        Import::BEHAVIOR_APPEND,
        Import::BEHAVIOR_DELETE,
        Import::BEHAVIOR_REPLACE
    ];

    /**
     * @var ValidatorPoolInterface
     */
    private $validatorPool;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var HandlerPoolInterface
     */
    private $handlerPool;

    /**
     * @var HandlerInterface
     */
    private $handler;

    /**
     * @var ImportResultInterface
     */
    private $importResult;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Array of primary keys of entities as keys and boolean true as values
     *
     * @var mixed[]
     */
    private $entities = [];

    /**
     * Initialize import
     *
     * @param Context $context
     * @param ValidatorPoolInterface $validatorPool
     * @param HandlerPoolInterface $handlerPool
     * @param LoggerInterface $logger
     * @param mixed[] $data
     */
    public function __construct(
        Context $context,
        ValidatorPoolInterface $validatorPool,
        HandlerPoolInterface $handlerPool,
        LoggerInterface $logger,
        array $data = []
    ) {
        $this->validatorPool = $validatorPool;
        $this->handlerPool = $handlerPool;
        $this->logger = $logger;

        parent::__construct(
            $context->getStringUtils(),
            $context->getScopeConfig(),
            $context->getImportFactory(),
            $context->getResourceHelper(),
            $context->getResource(),
            $context->getErrorAggregator(),
            $data
        );
    }

    /**
     * Import process start
     *
     * @return bool
     */
    public function importData()
    {
        $result = false;
        $this->_connection->beginTransaction();

        try {
            $result = $this->_importData();
            $this->_connection->commit();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            $this->_connection->rollBack();
        }

        return $result;
    }

    /**
     * Import data rows
     *
     * @return bool
     */
    protected function _importData()
    {
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            foreach ($bunch as $rowNumber => $rowData) {
                if ($this->isRowAllowedToImport($rowData, (int)$rowNumber)) {
                    $this->getHandler()->execute($rowData);
                }
            }
        }
        /* set import result */
        $this->importResult = $this->getHandler()->getImportResult();

        return true;
    }

    /**
     * Imported entity type code getter
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
        return 'eriocnemis_region';
    }

    /**
     * Retrieve true if row is valid and not in skipped rows array
     *
     * @param mixed[] $rowData
     * @param int $rowNumber
     * @return bool
     */
    public function isRowAllowedToImport(array $rowData, $rowNumber)
    {
        if ($this->getErrorAggregator()->hasToBeTerminated()) {
            $this->getErrorAggregator()->addRowToSkip($rowNumber);
        }
        return parent::isRowAllowedToImport($rowData, $rowNumber);
    }

    /**
     * Validate row data
     *
     * @param mixed[] $rowData
     * @param int $rowNumber
     * @return bool
     */
    public function validateRow(array $rowData, $rowNumber)
    {
        if (!isset($this->_validatedRows[$rowNumber])) {
            /** @var ValidationResult $result */
            $result = $this->getValidator()->validate($rowData);
            if (!$result->isValid()) {
                foreach ($result->getErrors() as $error) {
                    $this->addRowError($error, $rowNumber);
                }
            }

            $this->_validatedRows[$rowNumber] = true;
            /* update rows count */
            $this->_processedRowsCount++;
            /* update entities count */
            $key = $this->getPrimaryKey($rowData);
            if (empty($this->entities[$key])) {
                $this->entities[$key] = true;
                $this->_processedEntitiesCount++;
            }
        }
        return !$this->getErrorAggregator()->isRowInvalid($rowNumber);
    }

    /**
     * Retrieve validator for specific behavior
     *
     * @return ValidatorInterface
     * @throws LocalizedException
     */
    private function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = $this->validatorPool->get($this->getBehavior());
        }
        return $this->validator;
    }

    /**
     * Retrieve handler for specific behavior
     *
     * @return HandlerInterface
     * @throws LocalizedException
     */
    private function getHandler()
    {
        if (null === $this->handler) {
            $this->handler = $this->handlerPool->get($this->getBehavior());
        }
        return $this->handler;
    }

    /**
     * Retrieve count of created items
     *
     * @return int
     */
    public function getCreatedItemsCount()
    {
        return $this->importResult->getCreatedItemsCount();
    }

    /**
     * Retrieve count of updated items
     *
     * @return int
     */
    public function getUpdatedItemsCount()
    {
        return $this->importResult->getUpdatedItemsCount();
    }

    /**
     * Retrieve count of deleted items
     *
     * @return int
     */
    public function getDeletedItemsCount()
    {
        return $this->importResult->getDeletedItemsCount();
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
