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
use FastFeed\Exception\LogicException;
use FastFeed\Processor\ProcessorInterface;

/**
 * AbstractParser
 */
abstract class AbstractParser
{

    /**
     * @var array
     */
    protected $processors = array();

    /**
     * @return mixed
     * @throws \FastFeed\Exception\LogicException
     */
    public function popProcessor()
    {
        if (!$this->processors) {
            throw new LogicException('You tried to pop from an empty processor stack.');
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
} 