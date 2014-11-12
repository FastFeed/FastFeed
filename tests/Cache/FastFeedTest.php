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
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;

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

        $this->fastFeed = new FastFeed($this->guzzleMock, $this->loggerMock);
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

        $mock = new Mock([
            new Response(200, array()),         // Use response object
            "HTTP/1.1 200 OK\r\nContent-Length: 0\r\n\r\n"  // Use a response string
        ]);

        // Add the mock subscriber to the client.
        $this->guzzleMock->getEmitter()->attach($mock);

        $this->fastFeed->fetch('desarrolla2');
    }
}
