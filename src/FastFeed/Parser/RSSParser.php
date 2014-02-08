<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Parser;

use DOMElement;
use DOMDocument;
use FastFeed\Item;
use FastFeed\Exception\RuntimeException;

/**
 * RSSParser
 */
class RSSParser extends AbstractParser
{
    public function getNodes($content)
    {
        $items = array();
        $document = $this->createDocument($content);
        $nodes = $document->getElementsByTagName('item');
        if ($nodes->length) {
            foreach ($nodes as $node) {
                try {
                    $item = $this->create($node);
                    if (!$item) {
                        continue;
                    }
                    $items[] = $item;
                } catch (\Exception $e) {
                    throw new RuntimeException($e->getMessage());
                }
            }
        }

        return $items;
    }

    public function create(DOMElement $entry)
    {
        $item = new Item();
        $this->setProperties($entry, $item);

        return $item;
    }

    /**
     * @param DOMElement $node
     * @param Item       $item
     */
    protected function setProperties(DOMElement $node, Item $item)
    {
        $properties = array(
            'setName' => 'title'
        );
        foreach ($properties as $methodName => $propertyName) {
            $value = $this->getNodeValueByTagName($node, $propertyName);
            if ($value) {
                $item->$methodName($value);
            }
        }
    }

    protected function setPubDate(DOMElement $item, Item $item)
    {
        $value = $this->getNodeValueByTagName($item, 'pubDate');
        if ($value) {
            if (strtotime($value)) {
                $node->setPubDate(new DateTime($value));
            }
        }
    }

    /**
     * @param DOMElement $item
     * @param Item       $item
     */
    protected function setCategories(DOMElement $item, Item $item)
    {
        $categories = $this->getNodeValuesByTagName($item, 'category');
        foreach ($categories as $category) {
            $item->addCategory($category);
        }
    }

    /**
     * @param DOMElement $item
     * @param RSS20      $node
     */
    protected function setLink(DOMElement $item, Item $item)
    {
        $value = $this->getNodeValueByTagName($item, 'link');
        if ($this->isValidURL($value)) {
            $node->setLink($value);
        }
    }
} 