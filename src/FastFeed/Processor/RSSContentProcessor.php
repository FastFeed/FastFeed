<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Processor;

use DOMElement;
use FastFeed\Item;

/**
 * RSSContentProcessor
 */
class RSSContentProcessor extends AbstractProcessor implements ProcessorInterface
{
    /**
     * @param DOMElement $node
     * @param Item       $item
     */
    public function process(DOMElement $node, Item $item)
    {
        $this->setContent($node, $item);
    }

    /**
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