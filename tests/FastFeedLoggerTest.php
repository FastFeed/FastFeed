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
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;

/**
 * FastFeedLoggerTest
 */
class FastFeedLoggerTest extends AbstractFastFeedTest
{
    public function testFetch()
    {
        // Create a mock subscriber and queue two responses.
        $mock = new Mock([
            new Response(500, array()),         // Use response object
            "HTTP/1.1 500 \r\nContent-Length: 0\r\n\r\n"  // Use a response string
        ]);

        // Add the mock subscriber to the client.
        $this->guzzleMock->getEmitter()->attach($mock);

        $this->loggerMock->expects($this->once())
            ->method('log')
            ->will($this->returnValue(true));

        $this->fastFeed->addFeed('desarrolla2', 'http://desarrolla2.com/feed/');
        $this->fastFeed->pushParser(new RSSParser());
        $this->fastFeed->fetch('desarrolla2');
    }
}
