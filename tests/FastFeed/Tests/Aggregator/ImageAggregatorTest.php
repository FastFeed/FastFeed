<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Aggregator;

use DOMDocument;
use FastFeed\Item;
use FastFeed\Tests\Parser\AbstractParserTest;
use FastFeed\Aggregator\ImageAggregator;

/**
 * ImageProcessor
 */
class ImageAggregatorTest extends AbstractParserTest
{
    /**
     * @var ImageProcessor
     */
    protected $aggregator;

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
        $this->aggregator = new ImageAggregator();
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
                '<html><p><img alt="mi image"/></p></html>',
                '',
                '#b.gif#'
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
            $this->aggregator->addIgnoredPattern($pattern);
        }
        $this->aggregator->process($this->domElement, $this->item);
        $this->assertEquals($expectedImage, $this->item->getImage());
    }

    public function testSetIgnoredPatterns()
    {
        $patterns = array('1', '2');
        $this->aggregator->setIgnoredPatterns(array('1', '2'));
        $this->assertEquals($patterns, $this->aggregator->getIgnoredPatterns());
    }

    public function testNotOverrideImage()
    {
        $this->item->setImage('http://great.image.com/not-override.jpg');
        $this->item->setContent(
            '<img src="http://great.image.com/override.jpg"/>'
        );
        $this->aggregator->setOverrideImage(false);
        $this->aggregator->process($this->domElement, $this->item);

        $this->assertEquals('http://great.image.com/not-override.jpg', $this->item->getImage());
    }

    public function testOverrideImage()
    {
        $this->item->setImage('http://great.image.com/not-override.jpg');
        $this->item->setContent(
            '<img src="http://great.image.com/override.jpg"/>'
        );
        $this->aggregator->setOverrideImage(true);
        $this->aggregator->process($this->domElement, $this->item);

        $this->assertEquals('http://great.image.com/override.jpg', $this->item->getImage());
    }
}