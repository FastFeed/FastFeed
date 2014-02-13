# Instalación

Puedes instalar FastFeed de las siguientes maneras.

### Requerimientos

FastFeed funciona correctamente en todas las versiones de PHP5.3+

## Mediante composer

Instala FastFeed a través de composer añadiendo el siguiente bloque a tu fichero **composer.json**, puedes ver las
versiones disponibles en [packagist](https://packagist.org/packages/fastfeed/fastfeed).

``` json
    "require": {
        // ..
        "fastfeed/fastfeed": "dev-master"
    },
```

## Por tus propios medios

Descarga FastFeed desde su sitio en [GitHub](https://github.com/desarrolla2/RSSClient/releases) e incluyelo dentro
de la carpeta **vendors** de tu proyecto. Recuerda que FastFeed necesita un que tu lo registres en un sistema
autoloading compatible con el [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)

## Continua leyendo

[Usando FastFeed](https://github.com/FastFeed/FastFeed/blob/master/doc/es/uso.md)