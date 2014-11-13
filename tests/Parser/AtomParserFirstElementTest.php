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
use FastFeed\Parser\AtomParser;

/**
 * AtomFirstElementParserTest
 */
class AtomParserFirstElementTest extends AbstractAtomParserTest
{
    public function setUp()
    {
        $this->parser = new AtomParser();
    }

    public function dataProvider()
    {
        $data = array();

        foreach ($this->xmls as $xml) {
            $data[] = array(
                $xml,
            );
        }

        return $data;
    }

    /**
     * @dataProvider dataProvider
     */
    public function testId($fileName)
    {
        $content = $this->getContent($fileName);
        $item = $this->getItem($content);

        $expected = $this->getFirstValueFromXpath($content, "*/ns:id[1]");

        $this->assertEquals(
            $expected,
            $item->getId(),
            'Fail asserting that first element of '.$fileName.' has id "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testName($fileName)
    {
        $content = $this->getContent($fileName);
        $item = $this->getItem($content);

        $expected = $this->getFirstValueFromXpath($content, "*/ns:title[1]");

        $this->assertEquals(
            $expected,
            $item->getName(),
            'Fail asserting that first element of '.$fileName.' has name "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testIntro($fileName)
    {
        $content = $this->getContent($fileName);
        $item = $this->getItem($content);

        $expected = $this->getFirstValueFromXpath($content, "*/ns:content[1]");

        $this->assertEquals(
            $expected,
            $item->getIntro(),
            'Fail asserting that first element of '.$fileName.' has intro "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testContent($fileName)
    {
        $content = $this->getContent($fileName);
        $item = $this->getItem($content);

        $expected = $this->getFirstValueFromXpath($content, "*/ns:content[1]");

        $this->assertEquals(
            $expected,
            $item->getContent(),
            'Fail asserting that first element of '.$fileName.' has content "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSource($fileName)
    {
        $content = $this->getContent($fileName);
        $item = $this->getItem($content);

        $expected = $this->getFistAttributeFromXpath(
            $content,
            "*/ns:link[@rel='".AtomParser::SOURCE_LINK_ATTR."']",
            'href'
        );

        $this->assertEquals(
            $expected,
            $item->getSource(),
            'Fail asserting that first element of '.$fileName.' has source "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAuthor($fileName)
    {
        $content = $this->getContent($fileName);
        $item = $this->getItem($content);

        $expected = $this->getFirstValueFromXpath($content, "*/ns:email");

        $this->assertEquals(
            $expected,
            $item->getAuthor(),
            'Fail asserting that first element of '.$fileName.' has author "'.$expected.'"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testImage($fileName)
    {
        $content = $this->getContent($fileName);
        $item = $this->getItem($content);

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
    public function testDate($fileName)
    {
        $content = $this->getContent($fileName);
        $item = $this->getItem($content);

        $expected = strtotime($this->getFirstValueFromXpath($content, "*/ns:published"));

        $this->assertEquals(
            $expected,
            $item->getDate()->getTimestamp(),
            'Fail in assert of first element date of '.$fileName.'  '
        );
    }

    protected function getContent($xml)
    {
        return file_get_contents(__DIR__.$this->path.$xml);
    }

    protected function getItem($content)
    {
        $nodes = $this->parser->getNodes($content);

        return array_shift($nodes);
    }
}
