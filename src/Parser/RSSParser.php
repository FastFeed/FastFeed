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

namespace FastFeed\Parser;

use DateTime;
use DOMElement;

use FastFeed\Exception\RuntimeException;
use FastFeed\Item;

/**
 * RSSParser
 */
class RSSParser extends AbstractParser implements ParserInterface
{
    /**
     * Retrieve a Items's array
     *
     * @param $content
     *
     * @return array
     * @throws \FastFeed\Exception\RuntimeException
     */
    public function getNodes($content)
    {
        $items = array();
        $document = $this->createDocumentFromXML($content);
        $nodes = $document->getElementsByTagName('item');
        if ($nodes->length) {
            foreach ($nodes as $node) {
                try {
                    $item = $this->create($node);
                    $items[] = $item;
                } catch (\Exception $e) {
                    throw new RuntimeException($e->getMessage());
                }
            }
        }

        return $items;
    }

    /**
     * @param DOMElement $node
     *
     * @return Item
     */
    public function create(DOMElement $node)
    {
        $item = new Item();
        $this->setProperties($node, $item);
        $this->setDate($node, $item);
        $this->setTags($node, $item);
        $this->executeAggregators($node, $item);

        return $item;
    }

    /**
     * @return array
     */
    protected function getPropertiesMapping()
    {
        return array(
            'setId' => 'link',
            'setName' => 'title',
            'setIntro' => 'description',
            'setContent' => 'description',
            'setSource' => 'link',
            'setAuthor' => 'author',
        );
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
