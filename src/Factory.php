<?php

/**
 * This file is part of the FastFeed package.
 *
 * Copyright (c) Daniel González
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace FastFeed;

use Guzzle\Http\Client;

use FastFeed\Logger\Logger;
use FastFeed\Parser\AtomParser;
use FastFeed\Parser\RSSParser;

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
        $fastFeed = new FastFeed(new Client(), new Logger(false));
        $fastFeed->pushParser(new RSSParser());
        $fastFeed->pushParser(new AtomParser());

        return $fastFeed;
    }
}
