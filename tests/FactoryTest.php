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
use PHPUnit\Framework\TestCase;

/**
 * FactoryTest
 */
class FactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf('FastFeed\FastFeed', Factory::create());
    }
}
