<?php

/**
 * This file is part of the FastFeed package.
 *
 * Copyright (c) Daniel González
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace FastFeed\Aggregator;

use DOMElement;

use FastFeed\Item;

/**
 * ProcessorInterface
 */
interface AggregatorInterface
{
    /**
     * Execute the Aggregator
     *
     * @param DOMElement $node
     * @param Item       $item
     */
    public function process(DOMElement $node, Item $item);
}
