Processors
==========

What are they?
--------------

The **Processors** works at the end of the process, when you have recovered and parsing all elements.
Some uses of the processors may be limiting the number of items, sort by date or sanitize HTML.

Add it to FastFeed
------------------

The **Processors** should be added to FastFeed follows.

.. code-block:: php

    <?php
    use FastFeed\Processor\SanitizerProcessor;
    
    $fastFeed->pushProcessor(new SanitizerProcessor());

Processors available
--------------------

Currently we have these **Processors** available.

* FastFeed\Processor\ImageProcessor
* FastFeed\Processor\ImagesProcessor
* FastFeed\Processor\LimitProcessor
* FastFeed\Processor\PathProcessor
* FastFeed\Processor\RemoveStylesProcessor
* FastFeed\Processor\SanitizerProcessor
* FastFeed\Processor\SortByDateProcessor
* FastFeed\Processor\StripTagsProcessor

Create custom Processors
------------------------

Take a look to
`SortByDateProcessor <https://github.com/FastFeed/FastFeed/blob/master/src/FastFeed/Processor/SortByDateProcessor.php>`_.

Send us a PR with your **Processor**!

Continue reading
----------------

:doc:`cache`