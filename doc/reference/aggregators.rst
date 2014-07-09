Aggregators
===========

What are they?
--------------

The **Aggregators** resemble to **Parsers**, but they responsibility is add extra information. RSSParser is the
responsible to create the items from a feed rss, but the RSSContentAggregator is the responsible to modify the
items if the feed has the specification http://purl.org/rss/1.0/modules/content/

Add it to Parsers
-----------------

The  **Aggregators** should be added to a **Parser** as follows.

.. code-block:: php

    <?php
    use FastFeed\Parser\RSSParser;
    use FastFeed\Aggregator\RSSContentAggregator;

    $parser = new RSSParser();
    $parser->pushAggregator(new RSSContentAggregator());
    $fastFeed->pushParser($parser);


Aggregators available
---------------------

Currently we have these **Aggregators** available.

* FastFeed\Aggregator\EzRSSAggregator
* FastFeed\Aggregator\RSSContentAggregator

Create custom Aggregators
-------------------------

Take a look to
`RSSContentAggregator <https://github.com/FastFeed/FastFeed/blob/master/src/FastFeed/Aggregator/RSSContentAggregator.php>`_

Send us a PR with your **Aggregator**!

Continue reading
----------------

:doc:`processors`