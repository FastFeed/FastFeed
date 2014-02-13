# Usar Fast Feed

### Instancia Guzzle

FastFeed utiliza Guzzle para realizar las peticiones HTTP, esto lo convierte en un sistema muy flexible.

``` php
use Guzzle\Http\Client;

// Client
$client = new Client();
```
Aquí tienes la [documentación de guzzle](http://docs.guzzlephp.org/en/latest/http-client/client.html).

### Instancia Monolog

FastFeed necesita un sistema de logs, que implemente el
[PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) para gestionar logs,
nosotros te recomendamos utilizar monolog

``` php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Monolog
$logger = new Logger('name');
$logger->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));
```
Aquí tienes la [documentación de monolog](https://github.com/Seldaek/monolog/blob/master/README.mdown).

### Montalo todo

Ahora ya puedes crear la instancia de FastFeed.

``` php
use FastFeed\FastFeed;
use FastFeed\Parser\RSSParser;

$fastFeed = new FastFeed($client, $logger);
$fastFeed->pushParser(new RSSParser());
```

Si quieres saber más sobre los [parsers](https://github.com/FastFeed/FastFeed/blob/master/doc/es/parsers.md).

## Añade los feed

FastFeed maneja dos conceptos, los feeds representan una recurso, que tiene un contenido que quieres recuperar, los
canales son grupos de feeds.

``` php
$fastFeed->addFeed('default', 'http://desarrolla2.com/feed');
```
## Disfruta

Solo necesitas recuperar la información y usarla al gusto.

``` php
$items = $fastFeed->fetch('default');
foreach ($items as $item) {
    echo '<h1>' . $item->getName() . '</h1>' . PHP_EOL;
}
```

## Continua leyendo

[Parsers](https://github.com/FastFeed/FastFeed/blob/master/doc/es/parsers.md)