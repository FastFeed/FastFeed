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

use FastFeed\Item;
use FastFeed\Processor\LimitProcessor;

/**
 * LimitProcessorTest
 */
class LimitProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function dataProvider()
    {
        return array(
            array(2, 0, 2),
            array(2, 0, 2),
            array(2, 3, 2),
            array(3, 2, 2),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProcess($number, $limit, $expected)
    {
        $processor = new LimitProcessor($limit);
        $items = array_fill(0, $number, new Item());
        $items = $processor->process($items);
        $this->assertCount($expected, $items);
    }
}
