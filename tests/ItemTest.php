<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests;

use FastFeed\Item;
use DateTime;

/**
 * ItemTest
 */
class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testItem()
    {
        $item = new Item();
        $date = new DateTime();
        $item->setId('id');
        $item->setName('name');
        $item->setIntro('intro');
        $item->setContent('content');
        $item->setSource('source');
        $item->setAuthor('author');
        $item->setImage('image');
        $item->setDate($date);
        $item->setExtra('key', 'value');
        $item->setTags(array('tag'));

        $this->assertEquals('id', $item->getId());
        $this->assertEquals('name', $item->getName());
        $this->assertEquals('intro', $item->getIntro());
        $this->assertEquals('content', $item->getContent());
        $this->assertEquals('source', $item->getSource());
        $this->assertEquals('author', $item->getAuthor());
        $this->assertEquals('image', $item->getImage());
        $this->assertEquals($date, $item->getDate());
        $this->assertEquals('value', $item->getExtra('key'));
        $this->assertEquals(null, $item->getExtra('key-no-exist'));
        $this->assertEquals(array('tag'), $item->getTags());
    }
}
