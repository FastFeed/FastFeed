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

use FastFeed\Factory;
use Ivory\HttpAdapter\HttpAdapterFactory;

/**
 * FactoryTest
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        HttpAdapterFactory::register('mock_adapter', 'Ivory\HttpAdapter\MockHttpAdapter');
        $this->assertInstanceOf('FastFeed\FastFeed', Factory::create('mock_adapter'));
    }
}
