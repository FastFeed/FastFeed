# Parsers

## ¿Que son?

Son los responsables de analizar el texto y crear un array de elementos items. Actualmente hay implementados dos
tipos de parsers, uno para **RSS2.0** y otro para **Atom1.0** pero se podrían implementar parsers fácilmente para otros
formatos como por ejemplo **HTML** o **sitemaps.xml**

## Añadirlos a FastFeed

Simplemente instanciarlos y añadirlos al FastFeed

``` php
use FastFeed\Parser\AtomParser;
use FastFeed\Parser\RSSParser;

$fastFeed->pushParser(new RSSParser());
$fastFeed->pushParser(new AtomParser());
```

## Parsers disponibles

Actualmente tenemos estos **Parsers** disponibles.

+ FastFeed\Parser\AtomParser;
+ FastFeed\Parser\RSSParser;


## Crear un Parser personalizado

Aquí puedes ver un ejemplo de un **Parser** que recuperaría datos de un **sitemap.xml**

``` php
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
```

Envianos un PR con tus **Parser**!!

## Continua leyendo

[Agreggators](https://github.com/FastFeed/FastFeed/blob/master/doc/es/aggregators.md)