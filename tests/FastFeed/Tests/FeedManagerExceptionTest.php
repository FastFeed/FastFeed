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
 * FeedManagerExceptionTest
 */
class FeedManagerExceptionTest extends AbstractFastFeedTest
{

    /**
     * @return array
     */
    public function dataProviderForAddFeed()
    {

        return array(
            array(1, 1), // invalid channel
            array('default', 1), // invalid url
            array('default', 'invalid url'), // invalid url
        );
    }

    /**
     * @expectedException \FastFeed\Exception\InvalidArgumentException
     * @dataProvider dataProviderForAddFeed
     */
    public function testAddFeed($channel, $feed)
    {
        $this->fastFeed->addFeed($channel, $feed);
    }

    /**
     * @expectedException \FastFeed\Exception\InvalidArgumentException
     * @dataProvider dataProviderForAddFeed
     */
    public function testSetFeed($channel, $feed)
    {
        $this->fastFeed->setFeed($channel, $feed);
    }

    /**
     * @expectedException \FastFeed\Exception\LogicException
     */
    public function testGetFeed()
    {
        $this->fastFeed->getFeed('this channel no exist');
    }
}