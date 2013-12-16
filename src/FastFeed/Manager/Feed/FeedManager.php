<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastFeed\Manager\Feed;

/**
 * FeedManager manages feeds
 */
class FeedManager implements FeedManagerInterface
{
    /**
     * @var array
     */
    protected $feeds = array();

    /**
     * Set a channel
     *
     * @param string $channel
     * @param string $feed
     */
    public function setFeed($channel, $feed)
    {
        $this->feeds[(string)$channel] = array();
        $this->addFeed($channel, $feed);
    }

    /**
     * Add feed to channel
     *
     * @param string $channel
     * @param string $feed
     *
     * @throws \LogicException
     */
    public function addFeed($channel, $feed)
    {
        if (!filter_var($feed, FILTER_VALIDATE_URL)) {
            throw new \LogicException('You tried to add a invalid url.');
        }
        $this->feeds[(string)$channel][] = (string)$feed;
    }

    /**
     * Retrieve a channel
     *
     * @param string $channel
     *
     * @return string
     * @throws \LogicException
     */
    public function getFeed($channel)
    {
        if (!isset($this->feeds[$channel])) {
            throw new \LogicException('You tried to get a not existent channel');
        }

        return $this->feeds[$channel];
    }

    /**
     * Retrieve all channels
     *
     * @return array
     */
    public function getFeeds()
    {
        return $this->feeds;
    }

}