<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Processor;

use FastFeed\Item;
use FastFeed\Processor\PathProcessor;

/**
 * PathProcessorTest
 */
class PathProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PathProcessor
     */
    protected $processor;

    /**
     * @var array
     */
    protected $items;

    public function setUp()
    {
        $this->processor = new PathProcessor();
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
            array(
                '<a href="http://example.org/my/path/">link</a>',
                '<a href="/my/path/">link</a>',
                'http://example.org/my/other/path/',
            ),
            array(
                '<img src="http://example.org/my/path/"/>',
                '<img src="/my/path/"/>',
                'http://example.org/my/other/path/',
            ),
            array(
                '<img src="http://example.org/my/path/"/>',
                '<img src="http://example.org/my/path/"/>',
                'http://example.org/my/other/path/',
            ),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProcess($expected, $actual, $source)
    {
        $this->items[0]->setIntro($actual);
        $this->items[0]->setContent($actual);
        $this->items[0]->setSource($source);

        $this->items = $this->processor->process($this->items);
        $this->assertEquals($expected, $this->items[0]->getIntro());
        $this->assertEquals($expected, $this->items[0]->getContent());
    }
}
