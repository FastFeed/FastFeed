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
     * @expectedException \FastFeed\Exception\LogicException
     * @dataProvider dataProviderForAddFeed
     */
    public function testAddFeed($channel, $feed)
    {
        $this->fastFeed->addFeed($channel, $feed);
    }

    /**
     * @expectedException \FastFeed\Exception\LogicException
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

    /**
     * @expectedException \FastFeed\Exception\LogicException
     */
    public function testPopParser()
    {
        $this->fastFeed->popParser();
    }

    /**
     * @expectedException \FastFeed\Exception\LogicException
     */
    public function testPopProcessor()
    {
        $this->fastFeed->popProcessor();
    }

    /**
     * @expectedException \FastFeed\Exception\LogicException
     */
    public function testFetch()
    {
        $this->fastFeed->fetch(34);
    }
}
