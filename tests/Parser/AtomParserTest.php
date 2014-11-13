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

/**
 * AtomParserTest
 */
class AtomParserTest extends AbstractAtomParserTest
{
    public function dataProvider()
    {
        $data = array();

        foreach ($this->xmls as $xml) {
            $content = file_get_contents(__DIR__.$this->path.$xml);
            $data[] = array(
                $content,
                $xml,
            );
        }

        return $data;
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCountNodes($content, $fileName)
    {
        $nodes = $this->parser->getNodes($content);
        $expectedNodes = substr_count($content, '<entry>');
        $this->assertCount(
            $expectedNodes,
            $nodes,
            'Fail asserting that '.$fileName.' has '.$expectedNodes.' nodes'
        );
    }
}
