<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Cache;

use FastFeed\Tests\AbstractFastFeedTest;
use FastFeed\Cache\FastFeed;
use FastFeed\Item;
use Desarrolla2\Cache\CacheInterface;
use Ivory\HttpAdapter\Message\RequestInterface;

/**
 * FastFeedTest
 */
class FastFeedTest extends AbstractFastFeedTest
{
    /**
     * @var CacheInterface
     */
    protected $cacheMock;

    public function setUp()
    {
        parent::setUp();

        $this->cacheMock = $this->getMockBuilder('Desarrolla2\Cache\CacheInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->fastFeed = new FastFeed($this->httpMock, $this->loggerMock);
        $this->fastFeed->setCache($this->cacheMock);
        $this->fastFeed->addFeed('desarrolla2', 'http://desarrolla2.com/feed/');
    }

    public function testGetCache()
    {
        $this->assertInstanceOf('Desarrolla2\Cache\CacheInterface', $this->fastFeed->getCache());
    }

    public function testWithCache()
    {
        $this->cacheMock
            ->expects($this->once())
            ->method('has')
            ->will($this->returnValue(true));

        $this->cacheMock
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue(array(new Item())));

        $this->fastFeed->fetch('desarrolla2');
    }

    public function testWithOutCache()
    {
        $this->cacheMock
            ->expects($this->once())
            ->method('has')
            ->will($this->returnValue(false));

        $this->cacheMock
            ->expects($this->once())
            ->method('set')
            ->will($this->returnValue(true));

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

        $this->fastFeed->fetch('desarrolla2');
    }
}
