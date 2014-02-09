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
use DateTime;
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
        $this->setDate($entry, $item);
        $this->setTags($entry, $item);

        return $item;
    }

    /**
     * @param DOMElement $node
     * @param Item       $item
     */
    protected function setProperties(DOMElement $node, Item $item)
    {
        $properties = array(
            'setId' => 'link',
            'setName' => 'title',
            'setIntro' => 'description',
            'setContent' => 'description',
            'setSource' => 'link',
            'setAuthor' => 'author'
        );
        foreach ($properties as $methodName => $propertyName) {
            $value = $this->getNodeValueByTagName($node, $propertyName);
            if ($value) {
                $item->$methodName($value);
            }
        }
    }

    /**
     * @param DOMElement $node
     * @param Item       $item
     */
    protected function setDate(DOMElement $node, Item $item)
    {
        $value = $this->getNodeValueByTagName($node, 'pubDate');
        if ($value) {
            if (strtotime($value)) {
                $item->setDate(new DateTime($value));
            }
        }
    }

    /**
     * @param DOMElement $node
     * @param Item       $item
     */
    protected function setTags(DOMElement $node, Item $item)
    {
        $tags = $this->getNodeValuesByTagName($node, 'category');
        foreach ($tags as $tag) {
            $item->addTag($tag);
        }
    }

} 