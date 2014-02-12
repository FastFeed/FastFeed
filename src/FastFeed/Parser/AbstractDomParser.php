<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Parser;

use DOMElement;
use DOMDocument;
use DOMXPath;
use FastFeed\Item;
use FastFeed\Aggregator\AggregatorInterface;
use FastFeed\Exception\LogicException;
use FastFeed\Exception\RuntimeException;

/**
 * AbstractDomParser
 */
abstract class AbstractDomParser
{

    /**
     * @param $content
     *
     * @return DOMDocument
     * @throws \FastFeed\Exception\RuntimeException
     */
    protected function createDocument($content)
    {
        $previousValue = libxml_use_internal_errors(true);

        $document = new DOMDocument();
        $document->strictErrorChecking = false;
        $document->loadXML(trim($content));

        libxml_use_internal_errors($previousValue);

        return $document;
    }

    /**
     * @param DOMElement $node
     * @param            $tagName
     *
     * @return bool|string
     * @throws \FastFeed\Exception\RuntimeException
     */
    protected function getNodeValueByTagName(DOMElement $node, $tagName)
    {
        $results = $node->getElementsByTagName($tagName);
        for ($i = 0; $i < $results->length; $i++) {
            $result = $results->item($i);
            if (!$result->nodeValue) {
                continue;
            }

            return $result->nodeValue;
        }

        return false;
    }

    /**
     * @param DOMElement $node
     * @param            $namespace
     * @param            $tagName
     *
     * @return bool|string
     * @throws \FastFeed\Exception\RuntimeException
     */
    protected function getNodeValueByTagNameNS(DOMElement $node, $namespace, $tagName)
    {
        $results = $node->getElementsByTagNameNS($namespace, $tagName);
        for ($i = 0; $i < $results->length; $i++) {
            $result = $results->item($i);
            if (!$result->nodeValue) {
                continue;
            }

            return $result->nodeValue;
        }

        return false;
    }

    /**
     * @param DOMElement $node
     * @param            $tagName
     *
     * @return array
     * @throws \FastFeed\Exception\RuntimeException
     */
    protected function getNodeValuesByTagName(DOMElement $node, $tagName)
    {
        $values = array();
        $results = $node->getElementsByTagName($tagName);
        if ($results->length) {
            foreach ($results as $result) {
                if ($result->nodeValue) {
                    $values[] = $result->nodeValue;
                }
            }
        }

        return $values;
    }

    /**
     * @param DOMElement $node
     * @param            $tagName
     * @param            $propertyName
     *
     * @return array
     * @throws \FastFeed\Exception\RuntimeException
     */
    protected function getNodePropertyByTagName(\DOMElement $node, $tagName, $propertyName)
    {
        $values = array();
        $results = $node->getElementsByTagName($tagName);
        if ($results->length) {
            foreach ($results as $result) {
                if ($result->getAttribute($propertyName)) {
                    $values[] = $result->getAttribute($propertyName);
                }
            }
        }

        return $values;
    }
}