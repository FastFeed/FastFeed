<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Processor;

use FastFeed\Item;

/**
 * RemoveStylesProcessor
 */
class RemoveStylesProcessor implements ProcessorInterface
{
    /**
     * Execute processor
     *
     * @param array $items
     */
    public function process(array &$items)
    {
        foreach ($items as $key => $item) {
            $items[$key] = $this->removeStyle($item);
        }
    }

    /**
     * @param Item $item
     *
     * @return Item
     */
    public function removeStyle(Item $item)
    {
        $item->setIntro(preg_replace('/(<[^>]+) style=".*?"/i', '$1', $item->getIntro()));
        $item->setContent(preg_replace('/(<[^>]+) style=".*?"/i', '$1', $item->getContent()));

        return $item;
    }
}
