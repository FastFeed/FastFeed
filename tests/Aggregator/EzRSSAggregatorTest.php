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

use FastFeed\Tests\Parser\AbstractRSSParserTest;
use FastFeed\Parser\RSSParser;
use FastFeed\Aggregator\EzRSSAggregator;

class EzRSSAggregatorTest extends AbstractRSSParserTest
{
    /**
     * @var string
     */
    protected $path = '/../data/ezrss01/';

    /**
     * @var array
     */
    protected $xmls = array(
        'kickass.to.xml',
    );

    public function setUp()
    {
        $this->parser = new RSSParser();
        $this->parser->pushAggregator(new EzRSSAggregator());
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
    public function testAggregator($fileName)
    {
        $content = file_get_contents(__DIR__.$this->path.$fileName);
        $nodes   = $this->parser->getNodes($content);

        $item = array_shift($nodes);
        $keys = array('contentLength', 'infoHash', 'magnetURI', 'seeds', 'peers', 'verified', 'fileName');

        foreach ($keys as $key) {
            $expected = $this->getFirstValueFromXpath($content, "*/item/torrent:".$key);
            $this->assertEquals(
                $expected,
                $item->getExtra(
                    $key
                ),
                'Fail asserting that first element of '.$fileName.' has '.$key.' "'.$expected.'"'
            );
        }
    }
}
