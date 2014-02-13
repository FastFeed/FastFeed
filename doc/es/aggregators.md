# Aggregators

## ¿Que son?

Los **Aggregators** son parecidos a los **Parsers**, pero su función es añadir información extra. RSSParser es el
responsable de crear los items a partir de un feed rss, pero el RSSContentAggregator es el responsable de modificar los
items si el feed tiene tambien la expecificacion http://purl.org/rss/1.0/modules/content/

## Añadirlos a un Parser

Los **Aggregators** deben ser añadidos a un **Parser** de la siguiente forma.

``` php
use FastFeed\Parser\RSSParser;
use FastFeed\Aggregator\RSSContentAggregator;

$parser = new RSSParser();
$parser->pushAggregator(new RSSContentAggregator());
$fastFeed->pushParser($parser);
```

## Aggregators disponibles

Actualmente tenemos estos **Aggregators** disponibles.

+ FastFeed\Aggregator\RSSContentAggregator;
+ FastFeed\Aggregator\ImageAggregator;


## Crear un Aggregator a medida

Hecha un vistazo a
[RSSContentAggregator](https://github.com/FastFeed/FastFeed/blob/master/src/FastFeed/Aggregator/RSSContentAggregator.php).

Envianos un PR con tus **Aggregators**!!

## Continua leyendo

+ [Processors](https://github.com/FastFeed/FastFeed/blob/master/doc/es/processors.md)