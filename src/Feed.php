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

/**
 * Feed
 */
class Feed implements \Countable, \Iterator, \ArrayAccess
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $image;

    /**
     * @var array
     */
    protected $extra = [];

    /**
     * @var Item[]
     */
    protected $items = [];

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = (string) $content;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = (string) $source;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = (string) $language;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = (string) $author;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = (string) $image;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setExtra($key, $value)
    {
        $this->extra[$key] = (string) $value;
    }

    /**
     * @param string $key
     *
     * @return string|fasle
     */
    public function getExtra($key)
    {
        if (!isset($this->extra[$key])) {
            return;
        }

        return $this->extra[$key];
    }

    /**
     * @return Item
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * @return Item
     */
    public function next()
    {
        return next($this->items);
    }

    /**
     * @return Item
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->items) !== null;
    }

    /**
     *
     */
    public function rewind()
    {
        reset($this->items);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return Item|null
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param Item  $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->items[$offset]);
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
}
