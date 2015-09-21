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
use Ivory\HttpAdapter\Message\RequestInterface;

/**
 * FastFeedLoggerTest
 */
class FastFeedLoggerTest extends AbstractFastFeedTest
{
    public function testFetch()
    {
        $expectedResponse = $this->httpMock->getConfiguration()->getMessageFactory()->createResponse(
            200,
            RequestInterface::PROTOCOL_VERSION_1_1,
            ['Content-Type: application/json'],
            '{"hello":"world"}'
        );
        $this->httpMock->appendResponse($expectedResponse);

        $this->loggerMock->expects($this->once())
            ->method('log')
            ->will($this->returnValue(true));

        $this->fastFeed->addFeed('desarrolla2', 'http://desarrolla2.com/feed/');
        $this->fastFeed->pushParser(new RSSParser());
        $this->fastFeed->fetch('desarrolla2');
    }
}
