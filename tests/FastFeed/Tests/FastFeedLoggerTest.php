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

use FastFeed\Parser\RSSParser;

/**
 * FastFeedLoggerTest
 */
class FastFeedLoggerTest extends AbstractFastFeedTest
{
    public function testFetch()
    {
        $responseMock = $this->getMockBuilder('Guzzle\Http\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $responseMock
            ->expects($this->once())
            ->method('isSuccessful')
            ->will($this->returnValue(false));

        $responseMock->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(500));

        $requestMock = $this->getMockBuilder('Guzzle\Http\Message\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $requestMock->expects($this->once())
            ->method('send')
            ->will($this->returnValue($responseMock));

        $this->guzzleMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($requestMock));

        $this->loggerMock->expects($this->once())
            ->method('log')
            ->will($this->returnValue(true));

        $this->fastFeed->addFeed('desarrolla2', 'http://desarrolla2.com/feed/');
        $this->fastFeed->pushParser(new RSSParser());
        $this->fastFeed->fetch('desarrolla2');
    }
}
