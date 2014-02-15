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

    /**
     * @var \Guzzle\Http\ClientInterface
     */
    protected $guzzleMock;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $loggerMock;

    public function setUp()
    {
        $this->guzzleMock = $this->getMockBuilder('Guzzle\Http\ClientInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->fastFeed = new FastFeed($this->guzzleMock, $this->loggerMock);
    }
}
