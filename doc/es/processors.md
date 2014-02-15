# Processors

## ¿Que son?

Los **Processors** actuan al final del proceso, cuando ya se han recuperado y parseado todos los elementos.
Algunos usos de los procesadores pueden ser limitar el número de elementos, ordenarlos por fecha, o sanitizar el HTML.

## Añadirlos a FastFeed

Los **Processors** deben ser añadidos a FastFeed de la siguiente forma.

``` php
use FastFeed\Processor\SanitizerProcessor;

$fastFeed->pushProcessor(new SanitizerProcessor());
```

## Processors disponibles

Actualmente tenemos estos **Processors** disponibles.

+ FastFeed\Processor\ImageProcessor
+ FastFeed\Processor\LimitProcessor
+ FastFeed\Processor\SortByDateProcessor
+ FastFeed\Processor\SanitizerProcessor

## Crear un Processors a medida

Hecha un vistazo a
[SortByDateProcessor](https://github.com/FastFeed/FastFeed/blob/master/src/FastFeed/Processor/SortByDateProcessor.php).

Envianos un PR con tus **Processors**!!

## Continua leyendo

[Cache](https://github.com/FastFeed/FastFeed/blob/master/doc/es/cache.md)