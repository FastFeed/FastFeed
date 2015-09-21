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

use Ivory\HttpAdapter\HttpAdapterFactory;

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
    public static function create($adapter = 'guzzle')
    {
        $fastFeed = new FastFeed(HttpAdapterFactory::create($adapter), new Logger(false));
        $fastFeed->pushParser(new RSSParser());
        $fastFeed->pushParser(new AtomParser());

        return $fastFeed;
    }
}
