<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Logger;

use FastFeed\Logger\Logger;

/**
 * LoggerTest
 */
class LoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     *
     */
    public function setUp()
    {
        $this->logger = new Logger(false);
    }

    public function testLogger()
    {
        $this->logger->emergency('testing Logger');
        $this->logger->alert('testing Logger');
        $this->logger->critical('testing Logger');
        $this->logger->error('testing Logger');
        $this->logger->warning('testing Logger');
        $this->logger->notice('testing Logger');
        $this->logger->info('testing Logger');
        $this->logger->debug('testing Logger');
        $this->assertTrue(true);
    }
}
