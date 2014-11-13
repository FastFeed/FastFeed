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
 * SanitizerProcessorTest
 */
class SanitizerProcessorTest extends \PHPUnit_Framework_TestCase
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
        $this->processor = new SanitizerProcessor();
        $this->items = array(new Item());
    }

    /**
     * Provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return array(
            array('', ''),
            array('', '<img src="javascript:evil();" onload="evil();" />'),
            array('<b>Bold</b>', '<b>Bold'),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProcess($expected, $actual)
    {
        $this->items[0]->setIntro($actual);
        $this->items[0]->setContent($actual);
        $this->items = $this->processor->process($this->items);
        $this->assertEquals($expected, $this->items[0]->getIntro());
        $this->assertEquals($expected, $this->items[0]->getContent());
    }
}
