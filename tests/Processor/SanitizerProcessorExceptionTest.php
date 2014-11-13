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

use FastFeed\Processor\SanitizerProcessor;
use FastFeed\Item;

/**
 * SanitizerProcessorExceptionTest
 */
class SanitizerProcessorExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SanitizerProcessor
     */
    protected $processor;

    /**
     * @var array
     */
    protected $items;

    public function setUp()
    {
        $this->items = array(new Item());
    }

    /**
     * @expectedException \FastFeed\Exception\InvalidArgumentException
     */
    public function testException()
    {
        $this->processor = new SanitizerProcessor('/');
        $this->processor->process($this->items);
    }
}
