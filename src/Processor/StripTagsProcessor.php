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

namespace FastFeed\Processor;

use FastFeed\Item;

/**
 * StripTagsProcessor
 */
class StripTagsProcessor implements ProcessorInterface
{
    /**
     * @var
     */
    protected $allowedTags = array('content', 'intro');

    /**
     * @param mixed $allowedTags
     */
    public function setAllowedTagsForContent($allowedTags)
    {
        $this->allowedTags['content'] = $allowedTags;
    }

    /**
     * @param mixed $allowedTags
     */
    public function setAllowedTagsForIntro($allowedTags)
    {
        $this->allowedTags['intro'] = $allowedTags;
    }

    /**
     * Execute processor
     *
     * @param array $items
     *
     * @return array $items
     */
    public function process(array $items)
    {
        foreach ($items as $key => $item) {
            $items[$key] = $this->doClean($item);
        }

        return $items;
    }

    /**
     * @param Item $item
     *
     * @return Item
     */
    protected function doClean(Item $item)
    {
        $item->setIntro(strip_tags($item->getIntro(), $this->allowedTags['intro']));
        $item->setContent(strip_tags($item->getContent(), $this->allowedTags['content']));

        return $item;
    }
}
