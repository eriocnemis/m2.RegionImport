<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionImport\Model;

use Magento\Framework\Exception\LocalizedException;

/**
 * Behavior handlers pool
 */
class HandlerPool implements HandlerPoolInterface
{
    /**
     * @var HandlerInterface[]
     */
    protected $handlers = [];

    /**
     * Initialize pool
     *
     * @param HandlerInterface[] $handlers
     */
    public function __construct(
        $handlers = []
    ) {
        foreach ($handlers as $handler) {
            if (!$handler instanceof HandlerInterface) {
                throw new LocalizedException(
                    __('Behavior handler must implement %1.', HandlerInterface::class)
                );
            }
        }
        $this->handlers = $handlers;
    }

    /**
     * Retrieve handler for specific behavior
     *
     * @param string $behavior
     * @return HandlerInterface
     * @throws LocalizedException
     */
    public function get($behavior)
    {
        if (!isset($this->handlers[$behavior])) {
            throw new LocalizedException(
                __('There is no handler registered for behavior %1.', $behavior)
            );
        }
        return $this->handlers[$behavior];
    }
}
