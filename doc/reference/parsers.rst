Parsers
=======

What are they?
--------------

They are the responsible of analyze the text and create a array of items. Now we are implemented two kinds of parsers,
one for **RSS2.0** and other for **Atom1.0** but is easy to implement for other formats as **HTML** or **sitemap.xml**

Add it to FastFeed
------------------

Only instance and add it to FastFeed

.. code-block:: php

    <?php

    use FastFeed\Parser\AtomParser;
    use FastFeed\Parser\RSSParser;

    $fastFeed->pushParser(new RSSParser());
    $fastFeed->pushParser(new AtomParser());

Parsers available
-----------------

Currently we have these **Parsers** available.

* FastFeed\Parser\AtomParser;
* FastFeed\Parser\RSSParser;


Create custom Parser
--------------------

Here you can see an example of a **Parser** to recover data from a **sitemap.xml**

.. code-block:: php

    <?php

    class SiteMapParser extends AbstractParser implements ParserInterface
    {

        /**
         * Retrieve a Items's array
         *
         * @param $content
         *
         * @return array
         * @throws \FastFeed\Exception\RuntimeException
         */
        public function getNodes($content)
        {
            $items = array();
            $document = $this->createDocument($content);
            $nodes = $document->getElementsByTagName('url');
            if ($nodes->length) {
                foreach ($nodes as $node) {
                    try {
                        $item = $this->create($node);
                        $items[] = $item;
                    } catch (\Exception $e) {
                        throw new RuntimeException($e->getMessage());
                    }
                }
            }

            return $items;
        }

        /**
         * @param DOMElement $node
         *
         * @return Item
         */
        public function create(DOMElement $node)
        {
            $item = new Item();
            $this->setProperties($node, $item);

            return $item;
        }

        /**
         * @return array
         */
        protected function getPropertiesMapping()
        {
            return array(
                'setId' => 'loc',
                'setSource' => 'loc',
            );
        }
    }

Send us a PR with your **Parser**!

Continue reading
----------------

:doc:`aggregators`