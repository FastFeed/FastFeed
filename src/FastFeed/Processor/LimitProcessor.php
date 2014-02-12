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
 * LimitProcessor
 */
class LimitProcessor implements ProcessorInterface
{
    protected $limit;

    public function __construct($limit)
    {
        $this->limit = (int)$limit;
    }

    /**
     * @param array $items
     */
    public function process(array &$items)
    {
        if (!$this->limit) {
            return;
        }
        $total = count($items);
        if ($this->limit > $total) {
            return;
        }
        for ($i = $this->limit; $i < $total; $i++) {
            if (isset($items[$i])) {
                unset ($items[$i]);
            }
        }
    }
}