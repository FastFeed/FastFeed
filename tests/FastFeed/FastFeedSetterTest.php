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
 * FastFeedSetterTest
 */
class FastFeedSetterTest extends AbstractFastFeedTest
{

    public function testSetGuzzle()
    {

        $guzzleMock = $this->getMock('Guzzle\Http\ClientInterface');

        $this->assertNull($this->fastFeed->setHttpClient($guzzleMock));
    }

    public function testSetLogger()
    {
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');
        $this->assertNull($this->fastFeed->setLogger($loggerMock));
    }

} 