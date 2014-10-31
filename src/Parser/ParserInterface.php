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

namespace FastFeed\Parser;

/**
 * ParserInterface
 */
interface ParserInterface
{
    /**
     * Retrieve a Items's array
     *
     * @param $content
     *
     * @return array
     */
    public function getNodes($content);
}
