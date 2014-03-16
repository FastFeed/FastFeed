Using Fast Feed
===============

Factory way
-----------

FastFeed provide a Factory, to easy instanciate FastFeed.

.. code-block:: php

    <?php

    use FastFeed\Factory;

    $fastFeed = Factory::create();

Manual way
----------

Maybe you want more control about the FastFeed is create then continue reading

Instance Guzzle
^^^^^^^^^^^^^^^

FastFeed used Guzzle to perform HTTP requests, this makes for a very flexible system.

.. code-block:: php

    <?php

    use Guzzle\Http\Client;

    // Client
    $client = new Client();

Here you have `guzzle documentation <http://docs.guzzlephp.org/en/latest/http-client/client.html>`_.

Instance Monolog
^^^^^^^^^^^^^^^^

FastFeed needs a log system, that implements the
`PSR-3 <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md>`_
to manage log. We recommend you use monolog

.. code-block:: php

    <?php

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    // Monolog
    $logger = new Logger('name');
    $logger->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

Here you have the `monolog documentation <https://github.com/Seldaek/monolog/blob/master/README.mdown>`_.

Put it together
^^^^^^^^^^^^^^^

Now you can create FastFeed instance.

.. code-block:: php

    <?php

    use FastFeed\FastFeed;
    use FastFeed\Parser\RSSParser;

    $fastFeed = new FastFeed($client, $logger);
    $fastFeed->pushParser(new RSSParser());

If you want to know more about `parsers <https://github.com/FastFeed/FastFeed/blob/master/doc/es/parsers.md>`_.

Add feeds
---------

FastFeed manage two concepts, the feeds represent a resource that have content that you want retrieve. The channels are
a feed's group.

.. code-block:: php

    <?php

    $fastFeed->addFeed('default', 'http://desarrolla2.com/feed');

Enjoy
-----

You only need retrieve the information and use it as you want.

.. code-block:: php

    <?php

    $items = $fastFeed->fetch('default');
    foreach ($items as $item) {
        echo '<h1>' . $item->getName() . '</h1>' . PHP_EOL;
    }


Continue reading
----------------

:doc:`parsers`