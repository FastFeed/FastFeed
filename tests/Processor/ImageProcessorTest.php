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

use FastFeed\Processor\ImageProcessor;
use FastFeed\Item;

/**
 * ImageProcessorTest
 */
class ImageProcessorTest extends \PHPUnit_Framework_TestCase
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
        $this->processor = new ImageProcessor();
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
            array('', '', null),
            array('<html><p>no image here</p></html>', '', null),
            array(
                '<html><p><img src="http://great.image.com/image.jpg"/></p></html>',
                'http://great.image.com/image.jpg',
                null,
            ),
            array(
                '<html><p><img alt="mi image"/></p></html>',
                '',
                '#b.gif#',
            ),
            array(
                '<html><p><img src="http://great.image.com/b.gif"/></p></html>',
                '',
                '#b.gif#',
            ),
            array(
                '<p><a href="http://great.image.com/image.jpg"><img src="http://great.image.com/image.jpg" /></a></p>',
                'http://great.image.com/image.jpg',
                null,
            ),
            array(
                '<p><a href="http://great.image.com/image.jpg"><img src="http://great.image.com/image.jpg" /></a></p>'.
                '<p><img src="http://other.image.com/image.jpg" /></p>',
                'http://great.image.com/image.jpg',
                null,
            ),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProcess($content, $expectedImage, $pattern)
    {
        $this->items[0]->setContent($content);
        if ($pattern) {
            $this->processor->addIgnoredPattern($pattern);
        }
        $this->items = $this->processor->process($this->items);
        $this->assertEquals($expectedImage, $this->items[0]->getImage());
    }

    public function testSetIgnoredPatterns()
    {
        $patterns = array('1', '2');
        $this->processor->setIgnoredPatterns(array('1', '2'));
        $this->assertEquals($patterns, $this->processor->getIgnoredPatterns());
    }

    public function testNotOverrideImage()
    {
        $this->items[0]->setImage('http://great.image.com/not-override.jpg');
        $this->items[0]->setContent(
            '<img src="http://great.image.com/override.jpg"/>'
        );
        $this->processor->setOverrideImage(false);
        $this->processor->process($this->items);

        $this->assertEquals('http://great.image.com/not-override.jpg', $this->items[0]->getImage());
    }

    public function testOverrideImage()
    {
        $this->items[0]->setImage('http://great.image.com/not-override.jpg');
        $this->items[0]->setContent(
            '<img src="http://great.image.com/override.jpg"/>'
        );
        $this->processor->setOverrideImage(true);
        $this->processor->process($this->items);

        $this->assertEquals('http://great.image.com/override.jpg', $this->items[0]->getImage());
    }
}
