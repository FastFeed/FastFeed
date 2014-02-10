<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Processor;

use FastFeed\Tests\Parser\AbstractParserTest;
use FastFeed\Tests\Processor\ImageProcessor;

/**
 * ImageProcessor
 */
class ImageProcessorTest extends AbstractParserTest
{
    /**
     * @var ImageProcessor
     */
    protected $processor;

    public function setUp()
    {
        $this->processor = new ImageProcessor();
    }

    public function testImage()
    {

    }
} 