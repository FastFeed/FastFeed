<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Cache;

use FastFeed\Exception\LogicException;
use FastFeed\Exception;
use FastFeed\FastFeed as FastFeedBase;
use Desarrolla2\Cache\CacheInterface;

/**
 * FastFeed
 */
class FastFeed extends FastFeedBase
{

    /**
     * @var CacheInterface;
     */
    protected $cache;

    /**
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param string $channel
     *
     * @return array|CacheInterface
     */
    public function fetch($channel = 'default')
    {
        $items = $this->getFromCache($channel);
        if (!$items) {
            $items = parent::fetch($channel);
            $this->setToCache($channel, $items);
        }

        return $items;
    }

    /**
     * @param string $channel
     *
     * @return array
     * @throws \FastFeed\Exception\LogicException
     */
    protected function getFromCache($channel)
    {
        if (!$this->cache) {
            throw new LogicException('You need set to cache provider');
        }
        if ($this->getCache()->has($channel)) {
            return $this->getCache()->get($channel);
        }

        return false;
    }

    /**
     * @param string $channel
     * @param array  $items
     */
    protected function setToCache($channel, $items)
    {
        $this->getCache()->set($channel, $items);
    }
}
