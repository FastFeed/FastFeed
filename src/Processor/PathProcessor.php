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
use FastFeed\Url\Url;

/**
 * PathProcessor
 */
class PathProcessor implements ProcessorInterface
{
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
            $items[$key] = $this->fixPaths($item);
        }

        return $items;
    }

    /**
     * @param Item $item
     *
     * @return Item
     */
    protected function fixPaths(Item $item)
    {
        $url = new Url($item->getSource());
        $item->setIntro($this->getFixedText($item->getIntro(), $url->getFullHost()));
        $item->setContent($this->getFixedText($item->getContent(), $url->getFullHost()));

        return $item;
    }

    /**
     * @param $text
     * @param $domain
     *
     * @return mixed
     */
    protected function getFixedText($text, $domain)
    {
        $text = str_ireplace('href="/', 'href="' . $domain . '/', $text);
        $text = str_ireplace('href=\'/', 'href=\'' . $domain . '/', $text);
        $text = str_ireplace('src="/', 'src="' . $domain . '/', $text);
        $text = str_ireplace('src=\'/', 'src=\'' . $domain . '/', $text);

        return $text;
    }
}