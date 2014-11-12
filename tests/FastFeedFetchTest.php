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
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;

/**
 * FastFeedFetchTest
 */
class FastFeedFetchTest extends AbstractFastFeedTest
{
    public function dataProvider()
    {
        $content = file_get_contents(__DIR__ . '/data/rss20/desarrolla2.com.xml');

        return array(
            array(false),
            array('nothing here'),
            array($content)
        );

    }

    /**
     * @dataProvider dataProvider
     */
    public function testFetch($content)
    {
        $mock = new Mock([
            new Response(200, array()),         // Use response object
            "HTTP/1.1 200 OK\r\nContent-Length: 0\r\n\r\n"  // Use a response string
        ]);

        // Add the mock subscriber to the client.
        $this->guzzleMock->getEmitter()->attach($mock);

        $this->fastFeed->addFeed('desarrolla2', 'http://desarrolla2.com/feed/');
        $this->fastFeed->pushParser(new RSSParser());
        $this->fastFeed->fetch('desarrolla2');
    }
}
