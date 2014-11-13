<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Processor;

use DateTime;
use FastFeed\Item;
use FastFeed\Processor\SortByDateProcessor;

/**
 * SortByDateProcessorTest
 */
class SortByDateProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SortByDateProcessor
     */
    protected $processor = null;

    /**
     * @var array
     */
    protected $items;

    public function setUp()
    {
        $this->processor = new SortByDateProcessor();
        $this->items = array();
    }

    public function testProcess()
    {
        $this->items[0] = new Item();
        $this->items[1] = new Item();
        $this->items[2] = new Item();
        $this->items[3] = new Item();

        $date0 = new DateTime();
        $date1 = new DateTime();
        $date0->modify('-1 day');

        $this->items[0]->setDate($date0);
        $this->items[1]->setDate($date1);
        $this->items[2]->setDate($date0);

        $this->items = $this->processor->process($this->items);
        $this->assertEquals($this->items[0]->getDate(), $date1);
    }
}
