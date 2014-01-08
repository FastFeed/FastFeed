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

use FastFeed\Exception\LogicException;
use FastFeed\Exception\InvalidArgumentException;
use Guzzle\Http\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * FastFeed
 */
class FastFeed
{
    const VERSION = '0.1';

    const USER_AGENT = 'FastFeed/FastFeed';

    /**
     * @var ClientInterface;
     */
    protected $guzzle;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var array
     */
    protected $feeds = array();

    /**
     * @param ClientInterface $guzzle
     * @param LoggerInterface $logger
     */
    public function __construct(ClientInterface $guzzle, LoggerInterface $logger)
    {
        $this->guzzle = $guzzle;
        $this->logger = $logger;
    }

    /**
     * Set a channel
     *
     * @param string $channel
     * @param string $feed
     *
     * @throws InvalidArgumentException
     */
    public function setFeed($channel, $feed)
    {
        if (!is_string($channel)) {
            throw new InvalidArgumentException('You tried to add a invalid channel.');
        }
        $this->feeds[$channel] = array();
        $this->addFeed($channel, $feed);
    }

    /**
     * Add feed to channel
     *
     * @param string $channel
     * @param string $feed
     *
     * @throws InvalidArgumentException
     */
    public function addFeed($channel, $feed)
    {
        if (!is_string($channel)) {
            throw new InvalidArgumentException('You tried to add a invalid channel.');
        }
        if (!filter_var($feed, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('You tried to add a invalid url.');
        }
        $this->feeds[$channel][] = $feed;
    }

    /**
     * Retrieve a channel
     *
     * @param string $channel
     *
     * @return string
     * @throws LogicException
     */
    public function getFeed($channel)
    {
        if (!isset($this->feeds[$channel])) {
            throw new LogicException('You tried to get a not existent channel');
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

    /**
     * Retrieve content from a resource
     *
     * @param $url
     *
     * @return \Guzzle\Http\EntityBodyInterface|string
     */
    protected function get($url)
    {
        $request = $this->guzzle->get(
            $url,
            array('User-Agent' => self::USER_AGENT . ' v.' . self::VERSION)
        );
        $response = $request->send();

        if (!$response->isSuccessful()) {
            $this->logger->log(
                LogLevel::INFO,
                $response->getStatusCode() . ' http code in url "' . $url . '" '
            );

            return;
        }

        return $response->getBody();
    }

    /**
     * @param $message
     */
    protected function log($message)
    {
        $this->logger->log(
            LogLevel::INFO,
            '[' . self::USER_AGENT . ' v.' . self::VERSION . '] - ' . $message
        );
    }
}