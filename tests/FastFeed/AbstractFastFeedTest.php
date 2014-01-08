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
 * AbstractFeedManagerTest
 */
abstract class AbstractFastFeedTest extends \PHPUnit_Framework_TestCase
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
} 