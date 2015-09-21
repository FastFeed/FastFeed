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
            ['Content-Type: application/xml'],
            '<?xml version="1.0" encoding="utf-8"?>
            <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"
            xmlns:dc="http://purl.org/dc/elements/1.1/"
            xmlns:media="http://search.yahoo.com/mrss/"
            >
            <cache>
                <key>rss:9a0b0cb47a5834ce21b22b6a75e404544fe69aa9</key>
                <lastModKey>rss_modified:rss:9a0b0cb47a5834ce21b22b6a75e404544fe69aa9</lastModKey>
            </cache>
            <channel>
                <title>Test Response</title>
                <link>http://localhost/feed.xml</link>
                <description>A test feed.</description>
                <language>en-us</language>
                <lastBuildDate>Sun, 20 Sep 2015 20:17:05 -0700</lastBuildDate>
            </channel>
            </rss>'
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
