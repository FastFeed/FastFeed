<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Processor;

use DOMElement;
use DOMDocument;
use DOMXPath;
use FastFeed\Exception\RuntimeException;

/**
 * AbstractProcessor
 */
abstract class AbstractProcessor
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
        try {
            $document = new DOMDocument();
            $document->strictErrorChecking = false;
            $document->loadXML(trim($content));
        } catch (\Exception $e) {
            libxml_use_internal_errors($previousValue);
            throw new RuntimeException($e->getMessage());
        }
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
        try {
            $results = $node->getElementsByTagName($tagName);
            for ($i = 0; $i < $results->length; $i++) {
                $result = $results->item($i);
                if (!$result->nodeValue) {
                    continue;
                }

                return $result->nodeValue;
            }
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
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
        try {
            $results = $node->getElementsByTagNameNS($namespace, $tagName);
            for ($i = 0; $i < $results->length; $i++) {
                $result = $results->item($i);
                if (!$result->nodeValue) {
                    continue;
                }

                return $result->nodeValue;
            }
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
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
        try {
            $results = $node->getElementsByTagName($tagName);
            if ($results->length) {
                foreach ($results as $result) {
                    if ($result->nodeValue) {
                        $values[] = $result->nodeValue;
                    }
                }
            }
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
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
        try {
            $results = $node->getElementsByTagName($tagName);
            if ($results->length) {
                foreach ($results as $result) {
                    if ($result->getAttribute($propertyName)) {
                        $values[] = $result->getAttribute($propertyName);
                    }
                }
            }
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }

        return $values;
    }
}
