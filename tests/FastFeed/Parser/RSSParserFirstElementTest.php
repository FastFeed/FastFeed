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

/**
 * RSSParserFirstElementTest
 */
class RSSParserFirstElementTest extends AbstractRSSParserTest
{
    public function dataProvider()
    {
        parent::setUp();
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
    public function testName(Item $item, $content, $fileName)
    {
        $pattern = '#<item>[\s]*<title>[^\/]*<\/title>#';
        preg_match($pattern, $content, $match);
        $expectedName = trim(str_replace(array('<item>', '<title>', '</title>'), array('', '', ''), $match[0]));
        $this->assertEquals(
            $expectedName,
            $item->getName(),
            'Fail asserting that first element of ' . $fileName . ' has name "' . $expectedName . '"'
        );
    }

} 