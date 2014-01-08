<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastFeed\Manager\Feed;

use FastFeed\FastFeed;

/**
 * FeedManagerTest
 */
class FeedManager extends \PHPUnit_Framework_TestCase
{

    /**
     * @var FastFeed
     */
    protected $fastFeed;

    public function setUp()
    {
        $guzzleMock = $this->getMock('Guzzle\Http\ClientInterface');
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');

        $this->fastFeed = new FastFeed($guzzleMock, $loggerMock);
    }

    /**
     * @return array
     */
    public function dataProviderForTestAddFeed()
    {
        return array(
            array('http://www.test.org/'),
        );
    }

    /**
     * @dataProvider dataProviderForTestAddFeed
     */
    public function testAddFeed($feed)
    {
        $this->fastFeed->setFeed('channel', $feed);
        $this->assertCount(1, $this->fastFeed->getFeed('channel'));
    }

    /**
     * @dataProvider dataProviderForTestAddFeed
     */
    public function testSetFeed($feed)
    {
        $this->fastFeed->setFeed('channel', $feed);
        $this->assertCount(1, $this->fastFeed->getFeed('channel'));
    }

    public function testGetFeeds()
    {
        $this->assertEmpty($this->fastFeed->getFeeds());
    }
} 