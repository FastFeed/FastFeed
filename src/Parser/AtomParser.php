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
 * AtomParser
 */
class AtomParser extends AbstractParser implements ParserInterface
{
    const  SOURCE_LINK_ATTR = 'alternate';

    /**
     * Retrieve a Items's array
     *
     * @param string $content
     *
     * @return array
     * @throws \FastFeed\Exception\RuntimeException
     */
    public function getNodes($content)
    {
        $items = [];
        $document = $this->createDocumentFromXML($content);
        $nodes = $document->getElementsByTagName('entry');
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
        $this->setLink($node, $item);
        $this->setAuthor($node, $item);
        $this->setDate($node, $item);
        $this->setTags($node, $item);
        $this->executeAggregators($node, $item);

        if (!$item->getIntro()) {
            $item->setIntro($item->getContent());
        }

        return $item;
    }

    /**
     * @return array
     */
    protected function getPropertiesMapping()
    {
        return [
            'setId' => 'id',
            'setName' => 'title',
            'setIntro' => 'summary',
            'setContent' => 'content',
        ];
    }

    /**
     * @param DOMElement $node
     * @param Item       $item
     */
    protected function setLink(DOMElement $node, Item $item)
    {
        $nodeList = $node->getElementsByTagName('link');
        if ($nodeList->length) {
            foreach ($nodeList as $nodeResult) {
                if ($nodeResult->getAttribute('rel') != self::SOURCE_LINK_ATTR) {
                    continue;
                }
                $item->setSource($nodeResult->getAttribute('href'));

                break;
            }
        }
    }

    /**
     * @param DOMElement $node
     * @param Item       $item
     */
    protected function setAuthor(DOMElement $node, Item $item)
    {
        $nodeList = $node->getElementsByTagName('author');
        if ($nodeList->length) {
            foreach ($nodeList->item(0)->childNodes as $nodeResult) {
                if ($nodeResult->nodeName != 'email') {
                    continue;
                }
                $item->setAuthor($nodeResult->nodeValue);

                break;
            }
        }
    }

    /**
     * @param DOMElement $node
     * @param Item       $item
     */
    protected function setDate(DOMElement $node, Item $item)
    {
        $value = $this->getNodeValueByTagName($node, 'published');
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
        $tags = $this->getNodePropertyByTagName($node, 'category', 'term');
        foreach ($tags as $tag) {
            $item->addTag($tag);
        }
    }
}
