<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Manager\Feed\Parser;

use FastFeed\Item;
use DOMDocument;
use DOMXPath;
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
            $content = file_get_contents(__DIR__ . $this->path . $xml);
            $nodes = $this->parser->getNodes($content);
            $data[] = array(
                array_shift($nodes),
                $content,
                $xml
            );
        }

        return $data;
    }

    /**
     * @dataProvider dataProvider
     */
    public function testId(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item/link");

        $this->assertEquals(
            $expected,
            $item->getId(),
            'Fail asserting that first element of ' . $fileName . ' has id "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testName(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item/title");

        $this->assertEquals(
            $expected,
            $item->getName(),
            'Fail asserting that first element of ' . $fileName . ' has name "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testIntro(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item/description");

        $this->assertEquals(
            $expected,
            $item->getIntro(),
            'Fail asserting that first element of ' . $fileName . ' has intro "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testContent(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item/description");

        $this->assertEquals(
            $expected,
            $item->getContent(),
            'Fail asserting that first element of ' . $fileName . ' has content "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSource(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item/link");

        $this->assertEquals(
            $expected,
            $item->getSource(),
            'Fail asserting that first element of ' . $fileName . ' has source "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAuthor(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item/author");

        $this->assertEquals(
            $expected,
            $item->getAuthor(),
            'Fail asserting that first element of ' . $fileName . ' has author "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDate(Item $item, $content, $fileName)
    {
        $expected = strtotime($this->getFirstValueFromXpath($content, "*/item/pubDate"));

        $this->assertEquals(
            $expected,
            $item->getDate()->getTimestamp(),
            'Fail in assert of first element date of ' . $fileName . '  '
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testTags(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item/category");
        $tags = $item->getTags();

        if (!$expected) {
            $this->assertCount(
                0,
                $item->getTags(),
                'Fail asserting that first element of ' . $fileName . ' has no tags'
            );

            return;
        }

        $this->assertEquals(
            $expected,
            array_shift($tags),
            'Fail asserting that first element of ' . $fileName . ' has first tag "' . $expected . '"'
        );
    }

    /**
     * @param $content
     * @param $query
     *
     * @return string
     */
    protected function getFirstValueFromXpath($content, $query)
    {
        $domDocument = new DOMDocument();
        $domDocument->strictErrorChecking = false;
        $domDocument->loadXML(trim($content));

        $xpath = new DOMXPath($domDocument);
        $result = $xpath->query($query);

        $value = '';
        if ($result->length) {
            $value = $result->item(0)->nodeValue;
        }

        return $value;
    }

} 