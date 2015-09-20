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

use Ivory\HttpAdapter\HttpAdapterInterface;
use Ivory\HttpAdapter\Message\InternalRequest;
use Ivory\HttpAdapter\Message\Request;
use Ivory\HttpAdapter\MultiHttpAdapterException;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

use FastFeed\Exception\LogicException;
use FastFeed\Parser\ParserInterface;
use FastFeed\Processor\ProcessorInterface;

/**
 * FastFeed
 */
class FastFeed implements FastFeedInterface
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
     * @var HttpAdapterInterface;
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
    protected $processors = array();

    /**
     * @var array
     */
    protected $feeds = array();

    /**
     * @param HttpAdapterInterface $http
     * @param LoggerInterface $logger
     */
    public function __construct(HttpAdapterInterface $http, LoggerInterface $logger)
    {
        $this->http = $http;
        $this->logger = $logger;
    }

    /**
     * Add feed to channel
     *
     * @param string $channel
     * @param string $feed
     *
     * @throws LogicException
     */
    public function addFeed($channel, $feed)
    {
        if (!filter_var($feed, FILTER_VALIDATE_URL)) {
            throw new LogicException('You tried to add a invalid url.');
        }
        $this->feeds[$channel][] = $feed;
    }

    /**
     * @param string $channel
     *
     * @return Item[]
     * @throws Exception\LogicException
     */
    public function fetch($channel = 'default')
    {
        if (!is_string($channel)) {
            throw new LogicException('You tried to add a invalid channel.');
        }

        $items = $this->retrieve($channel);

        foreach ($this->processors as $processor) {
            $items = $processor->process($items);
        }

        return $items;
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
     * @return ProcessorInterface
     * @throws Exception\LogicException
     */
    public function popProcessor()
    {
        if (!$this->processors) {
            throw new LogicException('You tried to pop from an empty Processor stack.');
        }

        return array_shift($this->processors);
    }

    /**
     * @param ProcessorInterface $processor
     */
    public function pushProcessor(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;
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
     * Set Http Adapter
     *
     * @param HttpAdapterInterface $http
     */
    public function setHttpClient(HttpAdapterInterface $http)
    {
        $this->http = $http;
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
     * @throws LogicException
     */
    public function setFeed($channel, $feed)
    {
        if (!is_string($channel)) {
            throw new LogicException('You tried to add a invalid channel.');
        }
        $this->feeds[$channel] = array();
        $this->addFeed($channel, $feed);
    }

    /**
     * Retrieve content from a resource
     *
     * @param $url
     *
     * @return string
     */
    protected function get($url)
    {
        $response = $this->http->get(
            $url,
            array('User-Agent' => self::USER_AGENT.' v.'.self::VERSION)
        );

        if (!$response->isSuccessful()) {
            $this->log('fail with '.$response->getStatusCode().' http code in url "'.$url.'" ');

            return;
        }
        $this->logger->log(LogLevel::INFO, 'retrieved url "'.$url.'" ');

        return $response->getBody();
    }

    /**
     * @param $channel
     *
     * @return array
     */
    protected function retrieve($channel)
    {
        $result = array();

        foreach ($this->feeds[$channel] as $feed) {
            $content = $this->get($feed);
            if (!$content) {
                continue;
            }
            $result = array_merge($result, $this->parse($content));
        }

        return $result;
    }

    /**
     * @param $content
     *
     * @return array
     */
    protected function parse($content)
    {
        $result = array();
        foreach ($this->parsers as $parser) {
            $nodes = $parser->getNodes($content);
            if (!$nodes) {
                continue;
            }

            foreach ($nodes as $node) {
                $result[] = $node;
            }
        }

        return $result;
    }

    /**
     * @param $message
     */
    protected function log($message)
    {
        $this->logger->log(
            LogLevel::INFO,
            '['.self::USER_AGENT.' v.'.self::VERSION.'] - '.$message
        );
    }
}
