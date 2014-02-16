<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Cache;

use FastFeed\Cache\FastFeed;
use FastFeed\Tests\AbstractFastFeedTest;

/**
 * FastFeedManagerExceptionTest
 */
class FastFeedManagerExceptionTest extends AbstractFastFeedTest
{
    public function setUp()
    {
        parent::setUp();

        $this->fastFeed = new FastFeed($this->guzzleMock, $this->loggerMock);
        $this->fastFeed->addFeed('desarrolla2', 'http://desarrolla2.com/feed/');
    }

    /**
     * @expectedException \FastFeed\Exception\LogicException
     */
    public function testException()
    {
        $this->fastFeed->fetch('desarrolla2');
    }
}
