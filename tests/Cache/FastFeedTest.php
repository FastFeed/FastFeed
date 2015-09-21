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
            ['Content-Type: application/json'],
            '{"hello":"world"}'
        );

        $this->httpMock->appendResponse($expectedResponse);

        $this->fastFeed->fetch('desarrolla2');
    }
}
