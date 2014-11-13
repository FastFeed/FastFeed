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

use FastFeed\Processor\ImagesProcessor;
use FastFeed\Item;

/**
 * ImagesProcessorTest
 */
class ImagesProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ImageProcessor
     */
    protected $processor;

    /**
     * @var array
     */
    protected $items;

    public function setUp()
    {
        $this->processor = new ImagesProcessor();
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
            array('', array(), null),
            array('<html><p>no image here</p></html>', array(), null),
            array(
                '<html><p><img src="http://great.image.com/image.jpg"/></p></html>',
                array('http://great.image.com/image.jpg'),
                null,
            ),
            array(
                '<html><p><img alt="mi image"/></p></html>',
                array(),
                '#b.gif#',
            ),
            array(
                '<html><p><img src="http://great.image.com/b.gif"/></p></html>',
                array(),
                '#b.gif#',
            ),
            array(
                '<p><a href="http://great.image.com/image.jpg"><img src="http://great.image.com/image.jpg" /></a></p>',
                array('http://great.image.com/image.jpg'),
                null,
            ),
            array(
                '<p><a href="http://great.image.com/image.jpg"><img src="http://great.image.com/image.jpg" /></a></p>'.
                '<p><img src="http://other.image.com/image.jpg" /></p>',
                array('http://great.image.com/image.jpg', 'http://other.image.com/image.jpg'),
                null,
            ),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProcess($content, $expectedImages, $pattern)
    {
        $this->items[0]->setContent($content);
        if ($pattern) {
            $this->processor->addIgnoredPattern($pattern);
        }
        $this->items = $this->processor->process($this->items);
        $images = $this->items[0]->getExtra('images');
        $this->assertEquals($expectedImages, $images);
    }

    public function testSetIgnoredPatterns()
    {
        $patterns = array('1', '2');
        $this->processor->setIgnoredPatterns(array('1', '2'));
        $this->assertEquals($patterns, $this->processor->getIgnoredPatterns());
    }
}
