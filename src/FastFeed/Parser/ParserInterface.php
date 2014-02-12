<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
