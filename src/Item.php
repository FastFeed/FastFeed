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

use DateTime;

/**
 * Node
 */
class Item
{
    /**
     * @var string
     */
    protected $itemId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $intro;

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
    protected $author;

    /**
     * @var string
     */
    protected $image;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var array
     */
    protected $extra = array();

    /**
     * @var array
     */
    protected $tags = array();

    /**
     * @param string $itemId
     */
    public function setId($itemId)
    {
        $this->itemId = (string) $itemId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->itemId;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @param string $intro
     */
    public function setIntro($intro)
    {
        $this->intro = (string) $intro;
    }

    /**
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasImage()
    {
        return strlen($this->image) ? true : false;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = (string) $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $tag
     */
    public function addTag($tag)
    {
        $this->tags[] = (string) $tag;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = array();
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
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
    public function getSource()
    {
        return $this->source;
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
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        if (!$this->date) {
            return false;
        }

        return $this->date;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setExtra($key, $value)
    {
        $this->extra[$key] = $value;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function getExtra($key)
    {
        if (!isset($this->extra[$key])) {
            return;
        }

        return $this->extra[$key];
    }
}
