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

use FastFeed\Parser\AtomParser;

/**
 * AbstractAtomParserTest
 */
abstract class AbstractAtomParserTest extends AbstractParserTest
{
    /**
     * @var AtomParser
     */
    protected $parser;

    /**
     * @var string
     */
    protected $path = '/../data/atom10/';

    /**
     * @var array
     */
    protected $xmls = array(
        'diegohacking.blogspot.com.es.xml',
        'ubuntuleon.com.xml',
        'unawebmaslibre.blogspot.com.xml',
    );

    public function setUp()
    {
        $this->parser = new AtomParser();
    }
}
