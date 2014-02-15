# Processors

## What are they?

The **Processors** works at the end of the process, when you have recovered and parsing all elements.
Some uses of the processors may be limiting the number of items, sort by date or sanitize HTML.

## Add it to FastFeed

The **Processors** should be added to FastFeed follows.

``` php
use FastFeed\Processor\SanitizerProcessor;

$fastFeed->pushProcessor(new SanitizerProcessor());
```

## Processors available

Currently we have these **Processors** available.

+ FastFeed\Processor\ImageProcessor
+ FastFeed\Processor\LimitProcessor
+ FastFeed\Processor\RemoveStylesProcessor
+ FastFeed\Processor\SortByDateProcessor
+ FastFeed\Processor\SanitizerProcessor

## Create custom Processors

Take a look to
[SortByDateProcessor](https://github.com/FastFeed/FastFeed/blob/master/src/FastFeed/Processor/SortByDateProcessor.php).

Send us a PR with your **Processor**!

## Continue reading

[Cache](https://github.com/FastFeed/FastFeed/blob/master/doc/es/cache.md)