<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed;

use FastFeed\Parser\AtomParser;
use FastFeed\Parser\RSSParser;
use FastFeed\Logger\Logger;
use Guzzle\Http\Client;

/**
 * Factory
 */
abstract class Factory
{
    /**
     * @return FastFeed
     */
    public static function create()
    {
        $fastFeed = new FastFeed(new Client(), new Logger());
        $fastFeed->pushParser(new RSSParser());
        $fastFeed->pushParser(new AtomParser());

        return $fastFeed;
    }
}
