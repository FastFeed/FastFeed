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
 * FeedManagerTest
 */
class FeedManagerTest extends AbstractFastFeedTest
{
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
