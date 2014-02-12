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
 * Set the max number of items in result set
 */
class LimitProcessor implements ProcessorInterface
{
    /**
     * @var int
     */
    protected $limit;

    /**
     * @param int $limit
     */
    public function __construct($limit)
    {
        $this->setLimit($limit);
    }

    /**
     * Set the max number of items in result set
     *
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;
    }

    /**
     * Execute processor
     *
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