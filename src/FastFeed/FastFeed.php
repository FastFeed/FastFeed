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
use FastFeed\Parser\ParserInterface;
use Guzzle\Http\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * FastFeed
 */
class FastFeed
{
    /**
     * @const VERSION
     */
    const VERSION = '0.1';

    /**
     * @const USER_AGENT
     */
    const USER_AGENT = 'FastFeed/FastFeed';

    /**
     * @var ClientInterface;
     */
    protected $http;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var array
     */
    protected $parsers = array();

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
        $this->http = $guzzle;
        $this->logger = $logger;
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

    public function fetch($channel = 'default', $limit = 100)
    {
        if (!is_string($channel)) {
            throw new InvalidArgumentException('You tried to add a invalid channel.');
        }

        $result = array();

        foreach ($this->feeds[$channel] as $feed) {
            $content = $this->get($feed);
            if (!$content) {
                continue;
            }
            foreach ($this->parsers as $parser) {
                $nodes = $parser->getNodes($content);
                if (!$nodes) {
                    continue;
                }

                foreach ($nodes as $node) {
                    $result[] = $node;
                }
            }
        }

        foreach ($this->sanitizers as $sanitizer) {
            foreach ($result as $key => $node) {
                $result[$key] = $sanitizer->sanitize($node);
            }
        }

        if ($this->sort) {
            $result = $this->sort->sort($result);
        }

        if ($limit) {
            $result = $this->limit($result);
        }

        return $result;
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
     * @return ParserInterface
     * @throws Exception\LogicException
     */
    public function popParser()
    {
        if (!$this->parsers) {
            throw new LogicException('You tried to pop from an empty parsers stack.');
        }

        return array_shift($this->parsers);
    }

    /**
     * @param ParserInterface $parser
     */
    public function pushParser(ParserInterface $parser)
    {
        $this->parsers[] = $parser;
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
     * Set Guzzle
     *
     * @param ClientInterface $guzzle
     */
    public function setHttpClient(ClientInterface $guzzle)
    {
        $this->http = $guzzle;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
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
     * Retrieve content from a resource
     *
     * @param $url
     *
     * @return \Guzzle\Http\EntityBodyInterface|string
     */
    protected function get($url)
    {
        $request = $this->http->get(
            $url,
            array('User-Agent' => self::USER_AGENT . ' v.' . self::VERSION)
        );
        $response = $request->send();

        if (!$response->isSuccessful()) {
            $this->logger->log(
                LogLevel::INFO,
                'fail with ' . $response->getStatusCode() . ' http code in url "' . $url . '" '
            );

            return;
        }
        $this->logger->log(LogLevel::INFO, 'retrieved url "' . $url . '" ');

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