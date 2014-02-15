<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Parser;

use DOMDocument;
use DOMXPath;

/**
 * AbstractParserTest
 */
abstract class AbstractParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $content
     * @param $query
     *
     * @return string
     */
    protected function getFirstValueFromXpath($content, $query)
    {
        $node = $this->getFirstNodeFromXpath($content, $query);
        if (!$node) {
            return false;
        }

        return $node->nodeValue;
    }

    /**
     * @param $content
     * @param $query
     * @param $attribute
     *
     * @return bool|string
     */
    protected function getFistAttributeFromXpath($content, $query, $attribute)
    {
        $node = $this->getFirstNodeFromXpath($content, $query);
        if (!$node) {
            return false;
        }
        $nodeAttr = $node->attributes->getNamedItem($attribute);
        if (!$nodeAttr) {
            return false;
        }

        return $nodeAttr->nodeValue;
    }

    /**
     * @param $content
     * @param $query
     *
     * @return bool|\DOMNode
     */
    protected function getFirstNodeFromXpath($content, $query)
    {
        $document = new DOMDocument();
        $document->loadXML(trim($content));

        $xpath = new DOMXPath($document);
        $xpath->registerNamespace('ns', 'http://www.w3.org/2005/Atom');
        $result = $xpath->query($query);

        if ($result->length) {
            return $result->item(0);
        }

        return false;
    }
}
