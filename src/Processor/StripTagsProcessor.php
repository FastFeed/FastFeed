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
 * StripTagsProcessor
 */
class StripTagsProcessor implements ProcessorInterface
{
    /**
     * @var
     */
    protected $allowedTagsForIntro;

    /**
     * @var
     */
    protected $allowedTagsForContent;

    /**
     * @param mixed $allowedTagsForContent
     */
    public function setAllowedTagsForContent($allowedTagsForContent)
    {
        $this->allowedTagsForContent = $allowedTagsForContent;
    }

    /**
     * @param mixed $allowedTagsForIntro
     */
    public function setAllowedTagsForIntro($allowedTagsForIntro)
    {
        $this->allowedTagsForIntro = $allowedTagsForIntro;
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
        $item->setIntro(strip_tags($item->getIntro(), $this->allowedTagsForIntro));
        $item->setContent(strip_tags($item->getContent(), $this->allowedTagsForContent));

        return $item;
    }
}
