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
use FastFeed\Exception\RuntimeException;

/**
 * AbstractParser
 */
abstract class AbstractParser
{

    /**
     * @param $content
     *
     * @return DOMDocument
     * @throws \FastFeed\Exception\RuntimeException
     */
    protected function createDocument($content)
    {
        $previousUseLibXmlErrors = libxml_use_internal_errors(true);
        try {
            $domDocument = new DOMDocument();
            $domDocument->strictErrorChecking = false;
            $domDocument->loadXML(trim($content));
        } catch (\Exception $e) {
            libxml_use_internal_errors($previousUseLibXmlErrors);
            throw new RuntimeException($e->getMessage());
        }
        libxml_use_internal_errors($previousUseLibXmlErrors);

        return $domDocument;
    }

    /**
     * @param DOMElement $domNode
     * @param            $tagName
     *
     * @return bool|string
     * @throws \FastFeed\Exception\RuntimeException
     */
    protected function getNodeValueByTagName(DOMElement $domNode, $tagName)
    {
        try {
            $list = $domNode->getElementsByTagName($tagName);
            for ($i = 0; $i < $list->length; $i++) {
                $result = $list->item($i);
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
     * @param DOMElement $domNode
     * @param            $tagName
     * @param            $propertyName
     *
     * @return array
     * @throws \FastFeed\Exception\RuntimeException
     */
    protected function getNodePropertiesByTagName(DOMElement $domNode, $tagName, $propertyName)
    {
        $values = array();
        try {
            $results = $domNode->getElementsByTagName($tagName);
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

    /**
     * @param DOMElement $domNode
     * @param            $tagName
     *
     * @return array
     * @throws \FastFeed\Exception\RuntimeException
     */
    protected function getNodeValuesByTagName(\DOMElement $domNode, $tagName)
    {
        $values = array();
        try {
            $results = $domNode->getElementsByTagName($tagName);
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
     * @param $url
     *
     * @return bool
     */
    protected function isValidURL($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }
} 