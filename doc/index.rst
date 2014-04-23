Fast Feed
=========

FastFeed is a library that allows you to consume "feeds" atom or rss to be used in your applications.


FastFeed Status
---------------

+---------------+------------------+-----------------+--------------------+
| Name          | Badge            | Name            | Badge              |
+---------------+------------------+-----------------+--------------------+
| Build Status  | |Build_Status|_  | Latest Stable   | |Latest_Stable|_   |
+---------------+------------------+-----------------+--------------------+
| Quality Score | |Quality_Score|_ | Latest Stable   | |Latest_Unstable|_ |
+---------------+------------------+-----------------+--------------------+
| Code Coverage | |Code_Coverage|_ | Total Downloads | |Total_Downloads|_ |
+---------------+------------------+-----------------+--------------------+
| Insight       | |Insight|_       | License         | |License|_         |
+---------------+------------------+-----------------+--------------------+
| Dependencies  | |Dependencies|_  | ~               | ~                  |
+---------------+------------------+-----------------+--------------------+

.. |Build_Status| image:: https://secure.travis-ci.org/FastFeed/FastFeed.png
.. _Build_Status: http://travis-ci.org/FastFeed/FastFeed

.. |Latest_Stable| image:: https://poser.pugx.org/fastfeed/fastfeed/v/stable.png
.. _Latest_Stable: https://packagist.org/packages/fastfeed/fastfeed

.. |Quality_Score| image:: https://scrutinizer-ci.com/g/FastFeed/FastFeed/badges/quality-score.png?s=5ce39d3775f40b5946300404fa5fe3337a5ca66c
.. _Quality_Score: https://scrutinizer-ci.com/g/FastFeed/FastFeed/

.. |Latest_Unstable| image:: https://poser.pugx.org/fastfeed/fastfeed/v/unstable.png
.. _Latest_Unstable: https://packagist.org/packages/fastfeed/fastfeed

.. |Code_Coverage| image:: https://scrutinizer-ci.com/g/FastFeed/FastFeed/badges/coverage.png?s=50dbf6dfca4581c8e2761e5504d9de2a8db1d6fa
.. _Code_Coverage: https://scrutinizer-ci.com/g/FastFeed/FastFeed/

.. |Total_Downloads| image:: https://poser.pugx.org/fastfeed/fastfeed/downloads.png
.. _Total_Downloads: https://packagist.org/packages/fastfeed/fastfeed

.. |Insight| image:: https://insight.sensiolabs.com/projects/99e97a62-1005-4656-bd71-19639320ed0e/mini.png
.. _Insight: https://insight.sensiolabs.com/projects/99e97a62-1005-4656-bd71-19639320ed0e

.. |License| image:: https://poser.pugx.org/fastfeed/fastfeed/license.png
.. _License: https://packagist.org/packages/fastfeed/fastfeed

.. |Dependencies| image:: https://www.versioneye.com/user/projects/53256b3eec137563b4000368/badge.png
.. _Dependencies: https://www.versioneye.com/user/projects/53256b3eec137563b4000368


Features
--------

* Consume any number of channels grouped by feeds.
* Extends FastFeed easily to support new formats or retrieve information added by other specifications
* Recover ordering information according to your preferences.
* Modular and extensible.

Easy to use
---------------

FastFeed is easy to use.

.. code-block:: php

    <?php
    use FastFeed\Factory;

    $fastFeed = Factory::create();
    $fastFeed->addFeed('default', 'http://desarrolla2.com/feed');
    $items = $fastFeed->fetch('default');

Highly customizable
-------------------

You have a lot of options, read the docs for Parser, Aggregators and Processors. You have the perfect tool to
manipulate all kinds of feeds.

Great documentation
-------------------

We have a great documentation made with love.

* `Documentation <http://fastfeed.github.io/>`_
* `API <http://fastfeed.github.io/api/>`_
* `Code Coverage <http://fastfeed.github.io/coverage/>`_

Third party
-----------

We are working with various platforms to provide easier integration.

* `Symfony2 Bundle <https://github.com/FastFeed/FastFeedBundle>`_

Contact
-------

You can contact with me on `@twitter <https://twitter.com/desarrolla2>`_.

Reference Guide
---------------

.. toctree::
    :maxdepth: 3
    :numbered:

    reference/install
    reference/use
    reference/parsers
    reference/aggregators
    reference/processors
    reference/cache
    reference/faq

Cookbook
--------

Not ready yet :(