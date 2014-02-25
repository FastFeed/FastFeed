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

/**
 * SortByDateProcessor
 * Sort
 */
class SortByDateProcessor implements ProcessorInterface
{
    /**
     * Execute processor
     *
     * @param array $items
     *
     * @return array
     */
    public function process(array $items)
    {
        $total = count($items);
        for ($i = 1; $i < $total; $i++) {
            for ($j = 0; $j < $total - $i; $j++) {
                if (!$items[$j]->getDate() || !$items[$j + 1]->getDate()) {
                    continue;
                }
                if ($items[$j]->getDate()->getTimestamp() > $items[$j + 1]->getDate()->getTimestamp()) {
                    continue;
                }
                $aux = $items[$j + 1];
                $items[$j + 1] = $items[$j];
                $items[$j] = $aux;
            }
        }

        return $items;
    }
}
