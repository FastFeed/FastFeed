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
 * RSSContentAggregator
 *
 * This Aggregator seem for a content:encoded field in item node and set as description
 */
class RSSContentAggregator extends AbstractAggregator implements AggregatorInterface
{
    /**
     * Execute the Aggregator
     *
     * @param DOMElement $node
     * @param Item       $item
     */
    public function process(DOMElement $node, Item $item)
    {
        $this->setContent($node, $item);
    }

    /**
     *
     * @param DOMElement $node
     * @param Item       $item
     */
    protected function setContent(DOMElement $node, Item $item)
    {
        $value = $this->getNodeValueByTagNameNS($node, 'http://purl.org/rss/1.0/modules/content/', 'encoded');

        if ($value) {
            $item->setContent($value);
        }
    }
}
