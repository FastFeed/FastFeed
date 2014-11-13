<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests;


/**
 * FastFeedSetterTest
 */
class FastFeedSetterTest extends AbstractFastFeedTest
{
    public function testSetGuzzle()
    {
        $guzzleMock = $this->getMock('Guzzle\Http\ClientInterface');
        $this->assertNull($this->fastFeed->setHttpClient($guzzleMock));
    }

    public function testSetLogger()
    {
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');
        $this->assertNull($this->fastFeed->setLogger($loggerMock));
    }

    public function testPushParser()
    {
        $parserMock = $this->getMock('FastFeed\Parser\ParserInterface');
        $this->assertNull($this->fastFeed->pushParser($parserMock));
    }

    public function testPopParser()
    {
        $parserMock = $this->getMock('FastFeed\Parser\ParserInterface');
        $this->fastFeed->pushParser($parserMock);
        $this->assertInstanceOf('FastFeed\Parser\ParserInterface', $this->fastFeed->popParser());
    }

    public function testPushProcessor()
    {
        $processorMock = $this->getMock('FastFeed\Processor\ProcessorInterface');
        $this->assertNull($this->fastFeed->pushProcessor($processorMock));
    }

    public function testPopProcessor()
    {
        $processorMock = $this->getMock('FastFeed\Processor\ProcessorInterface');
        $this->fastFeed->pushProcessor($processorMock);
        $this->assertInstanceOf('FastFeed\Processor\ProcessorInterface', $this->fastFeed->popProcessor());
    }
}
