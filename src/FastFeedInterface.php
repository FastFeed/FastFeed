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
use Psr\Log\LoggerInterface;

use FastFeed\Parser\ParserInterface;
use FastFeed\Processor\ProcessorInterface;

/**
 * FeedManagerInterface
 */
interface FastFeedInterface
{
    /**
     * Add feed to channel
     *
     * @param string $channel
     * @param string $feed
     *
     * @throws InvalidArgumentException
     */
    public function addFeed($channel, $feed);

    /**
     * @param string $channel
     *
     * @return array
     * @throws Exception\InvalidArgumentException
     */
    public function fetch($channel = 'default');

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
     * @return ParserInterface
     * @throws Exception\LogicException
     */
    public function popParser();

    /**
     * @param ParserInterface $parser
     */
    public function pushParser(ParserInterface $parser);

    /**
     * @return ProcessorInterface
     * @throws Exception\LogicException
     */
    public function popProcessor();

    /**
     * @param ProcessorInterface $processor
     */
    public function pushProcessor(ProcessorInterface $processor);

    /**
     * Retrieve all channels
     *
     * @return array
     */
    public function getFeeds();

    /**
     * Set Http Adapter
     *
     * @param HttpAdapterInterface $http
     */
    public function setHttpClient(HttpAdapterInterface $http);

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger);

    /**
     * Set a channel
     *
     * @param string $channel
     * @param string $feed
     *
     * @throws InvalidArgumentException
     */
    public function setFeed($channel, $feed);
}
