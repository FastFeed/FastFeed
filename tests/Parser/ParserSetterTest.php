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

use FastFeed\Parser\RSSParser;

/**
 * ParserManagerTest
 */
class ParserSetterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RSSParser
     */
    protected $parser;
    public function setUp()
    {
        $this->parser = new RSSParser();
    }

    public function testPushProcessor()
    {
        $aggregatorMock = $this->getMock('FastFeed\Aggregator\AggregatorInterface');
        $this->assertNull($this->parser->pushAggregator($aggregatorMock));
    }

    public function testPopParser()
    {
        $aggregatorMock = $this->getMock('FastFeed\Aggregator\AggregatorInterface');
        $this->parser->pushAggregator($aggregatorMock);
        $this->assertInstanceOf('FastFeed\Aggregator\AggregatorInterface', $this->parser->popAggregator());
    }

    /**
     * @expectedException \FastFeed\Exception\LogicException
     */
    public function testPopProcessor()
    {
        $this->parser->popAggregator();
    }
}
