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

use FastFeed\Parser\RSSParser;

/**
 * AbstractRSSParserTest
 */
abstract class AbstractRSSParserTest extends AbstractParserTest
{
    /**
     * @var RSSParser
     */
    protected $parser;

    /**
     * @var string
     */
    protected $path = '/../data/rss20/';

    /**
     * @var array
     */
    protected $xmls = array(
        'banen.bol.com.xml',
        'desarrolla2.com.xml',
        'jhosman.com.xml',
        'libuntu.com.xml',
        'nytimes.com.xml',
        'slashdot.com.xml',
        'ubuntu-espana.org.xml',
        'ubuntuleon.com.xml',
    );

    public function setUp()
    {
        $this->parser = new RSSParser();
    }

    /**
     * @param $content
     * @param $query
     *
     * @return string
     */
    protected function getFirstValueFromXpath($content, $query)
    {
        try {
            $dom = new \DOMDocument();
            $dom->loadXML(trim($content));

            $xpath  = new \DOMXPath($dom);
            $result = $xpath->query($query);

            if ($result->length) {
                return $result->item(0)->nodeValue;
            }
        } catch (\Exception $e) {
        }

        return false;
    }
}
