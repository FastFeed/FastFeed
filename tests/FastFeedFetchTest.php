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

/**
 * FastFeedFetchTest
 */
class FastFeedFetchTest extends AbstractFastFeedTest
{
    public function dataProvider()
    {
        $content = file_get_contents(__DIR__.'/data/rss20/desarrolla2.com.xml');

        return array(
            array(false),
            array('nothing here'),
            array($content),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testFetch($content)
    {
        $responseMock = $this->getMockBuilder('Guzzle\Http\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $responseMock
            ->expects($this->once())
            ->method('isSuccessful')
            ->will($this->returnValue(true));

        $responseMock->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));

        $requestMock = $this->getMockBuilder('Guzzle\Http\Message\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $requestMock->expects($this->once())
            ->method('send')
            ->will($this->returnValue($responseMock));

        $this->guzzleMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($requestMock));

        $this->fastFeed->addFeed('desarrolla2', 'http://desarrolla2.com/feed/');
        $this->fastFeed->pushParser(new RSSParser());
        $this->fastFeed->fetch('desarrolla2');
    }
}
