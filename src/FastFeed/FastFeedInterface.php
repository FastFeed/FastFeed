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

/**
 * FeedManagerInterface
 */
interface FeedManagerInterface
{
    /**
     * Set a channel
     *
     * @param string $channel
     * @param string $feed
     */
    public function setFeed($channel, $feed);

    /**
     * Add feed to channel
     *
     * @param string $channel
     * @param string $feed
     */
    public function addFeed($channel, $feed);

    /**
     * Retrieve a channel
     *
     * @param string $channel
     *
     * @return string
     * @throws LogicException
     */
    public function getFeed($channel);

    /**
     * Retrieve all channels
     *
     * @return array
     */
    public function getFeeds();

} 