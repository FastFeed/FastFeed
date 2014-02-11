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

use DOMDocument;
use FastFeed\Item;
use FastFeed\Tests\Parser\AbstractParserTest;
use FastFeed\Processor\ImageProcessor;

/**
 * ImageProcessor
 */
class ImageProcessorTest extends AbstractParserTest
{
    /**
     * @var ImageProcessor
     */
    protected $processor;

    /**
     * @var Item
     */
    protected $item;

    /**
     * @var DOMElement
     */
    protected $domElement;

    public function setUp()
    {
        $this->item = new Item();
        $this->processor = new ImageProcessor();
        $dom = new DOMDocument();
        $dom->loadHTML('<html><p>nothing here</p></html>');
        $this->domElement = $dom->documentElement;
    }

    /**
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
                null
            ),
            array(
                '<html><p><img src="http://great.image.com/b.gif"/></p></html>',
                '',
                '#b.gif#'
            ),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testImage($content, $expectedImage, $pattern)
    {
        $this->item->setContent($content);
        if ($pattern) {
            $this->processor->addIgnoredPattern($pattern);
        }
        $this->processor->process($this->domElement, $this->item);
        $this->assertEquals($expectedImage, $this->item->getImage());
    }

    public function testSetIgnoredPatterns()
    {
        $patterns = array('1', '2');
        $this->processor->setIgnoredPatterns(array('1', '2'));
        $this->assertEquals($patterns, $this->processor->getIgnoredPatterns());
    }

    public function testSetOverrideImage()
    {
        $this->processor->setOverrideImage(true);
        $this->assertTrue($this->processor->getOverrideImage());
    }

    public function testNotOverrideImage()
    {
        $this->item->setImage('http://great.image.com/not-override.jpg');
        $this->item->setContent(
            '<img src="http://great.image.com/override.jpg"/>'
        );
        $this->processor->setOverrideImage(false);
        $this->processor->process($this->domElement, $this->item);

        $this->assertEquals('http://great.image.com/not-override.jpg', $this->item->getImage());
    }

    public function testOverrideImage()
    {
        $this->item->setImage('http://great.image.com/not-override.jpg');
        $this->item->setContent(
            '<img src="http://great.image.com/override.jpg"/>'
        );
        $this->processor->setOverrideImage(true);
        $this->processor->process($this->domElement, $this->item);

        $this->assertEquals('http://great.image.com/override.jpg', $this->item->getImage());
    }
} 