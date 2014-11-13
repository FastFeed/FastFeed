<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Parser;

use FastFeed\Item;
use FastFeed\Parser\RSSParser;

/**
 * RSSParserFirstElementTest
 */
class RSSParserFirstElementTest extends AbstractRSSParserTest
{
    public function dataProvider()
    {
        $this->parser = new RSSParser();
        $data = array();

        foreach ($this->xmls as $xml) {
            $content = file_get_contents(__DIR__.$this->path.$xml);
            $nodes = $this->parser->getNodes($content);
            $data[] = array(
                array_shift($nodes),
                $content,
                $xml,
            );
        }

        return $data;
    }

    /**
     * @dataProvider dataProvider
     */
    public function testId(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item[1]/link");

        $this->assertEquals(
            $expected,
            $item->getId(),
            'Fail asserting that first element of '.$fileName.' has id "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testName(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item[1]/title");

        $this->assertEquals(
            $expected,
            $item->getName(),
            'Fail asserting that first element of '.$fileName.' has name "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testIntro(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item[1]/description");

        $this->assertEquals(
            $expected,
            $item->getIntro(),
            'Fail asserting that first element of '.$fileName.' has intro "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testContent(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item[1]/description");

        $this->assertEquals(
            $expected,
            $item->getContent(),
            'Fail asserting that first element of '.$fileName.' has content "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSource(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item[1]/link");

        $this->assertEquals(
            $expected,
            $item->getSource(),
            'Fail asserting that first element of '.$fileName.' has source "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAuthor(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item[1]/author");

        $this->assertEquals(
            $expected,
            $item->getAuthor(),
            'Fail asserting that first element of '.$fileName.' has author "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testImage(Item $item, $content, $fileName)
    {
        $expected = null;

        $this->assertEquals(
            $expected,
            $item->getImage(),
            'Fail asserting that first element of '.$fileName.' has image "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDate(Item $item, $content, $fileName)
    {
        $expected = strtotime($this->getFirstValueFromXpath($content, "*/item[1]/pubDate"));

        $this->assertEquals(
            $expected,
            $item->getDate()->getTimestamp(),
            'Fail in assert of first element date of '.$fileName.'  '
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testTags(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item[1]/category");
        $tags = $item->getTags();

        if (!$expected) {
            $this->assertCount(
                0,
                $item->getTags(),
                'Fail asserting that first element of '.$fileName.' has no tags'
            );

            return;
        }

        $this->assertEquals(
            $expected,
            array_shift($tags),
            'Fail asserting that first element of '.$fileName.' has first tag "'.$expected.'"'
        );
    }
}
