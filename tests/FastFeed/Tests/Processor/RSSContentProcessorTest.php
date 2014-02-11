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
use DOMXPath;
use FastFeed\Item;
use FastFeed\Parser\RSSParser;
use FastFeed\Processor\RSSContentProcessor;
use FastFeed\Tests\Parser\AbstractRSSParserTest;

/**
 * RSSContentProcessorTest
 */
class RSSContentProcessorTest extends AbstractRSSParserTest
{
    public function dataProvider()
    {
        $this->parser = new RSSParser();
        $this->parser->pushProcessor(new RSSContentProcessor());
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
    public function testContent(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/item/content:encoded");
        if (!$expected) {
            $expected = $item->getContent();
        }

        $this->assertEquals(
            $expected,
            $item->getContent(),
            'Fail asserting that first element of ' . $fileName . ' has content "' . $expected . '"'
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
        try {
            $dom = new DOMDocument();
            $dom->loadXML(trim($content));

            $xpath = new DOMXPath($dom);
            $result = $xpath->query($query);

            if ($result->length) {
                return $result->item(0)->nodeValue;
            }
        } catch (\Exception $e) {

        }

        return false;
    }
} 