<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastFeed\Aggregator;

use DOMElement;
use FastFeed\Item;

/**
 * Class EzRSSAggregator
 */
class EzRSSAggregator extends AbstractAggregator implements AggregatorInterface
{
    protected $keys = array('contentLength', 'infoHash', 'magnetURI', 'seeds', 'peers', 'verified', 'fileName');

    /**
     * Execute the Aggregator
     *
     * @param DOMElement $node
     * @param Item       $item
     */
    public function process(DOMElement $node, Item $item)
    {
        foreach ($this->keys as $key) {
            $item->setExtra($key, $this->getValue($node, $key));
        }
    }

    /**
     * @param DOMElement $node
     * @param string     $tagName
     *
     * @return bool|string
     */
    protected function getValue(DOMElement $node, $tagName)
    {
        return $this->getNodeValueByTagNameNS($node, 'http://xmlns.ezrss.it/0.1/', $tagName);
    }
}
