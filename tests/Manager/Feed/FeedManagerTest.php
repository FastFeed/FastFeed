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

use FastFeed\Manager\Feed\FeedManager;

/**
 * FeedManagerTest
 */
class FeedManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var FeedManager
     */
    protected $feedManager;

    public function setUp()
    {
        $this->feedManager = new FeedManager();
    }

    public function dataProviderForTestSetFeed()
    {
        return array(
            array('http://feed1.com')
        );
    }

    /**
     * @test
     * @dataProvider dataProviderForTestSetFeed
     */
    public function testSetFeed($feed)
    {
        $this->feedManager->setFeed('channel', $feed);
        $this->assertCount(1, $this->feedManager->getFeed('channel'));
    }
} 