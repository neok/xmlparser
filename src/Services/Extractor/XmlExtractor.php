<?php

namespace App\Services\Extractor;

/**
 * Class XmlExtractor
 */
class XmlExtractor implements ExtractorInterface
{

    private const BATCH_SIZE = 150;

    /**
     * @param        $file
     * @param string $type
     *
     * @return \Generator
     */
    public function extract($file, string $type): \Generator
    {
        $options = LIBXML_NOENT | LIBXML_COMPACT | LIBXML_PARSEHUGE | LIBXML_NOERROR | LIBXML_NOWARNING;
        $this->reader = new \XMLReader($options);
        $this->reader->open($file);
        $res = [];
        $this->reader->setParserProperty(\XMLReader::SUBST_ENTITIES, true);
        while ($this->reader->read()) {
            if ($this->reader->nodeType === \XMLReader::ELEMENT && $this->reader->name === $type) {
                $item = simplexml_load_string($this->reader->readOuterXml());
                $dataItem = [];

                foreach ($item as $k => $el) {
                    $dataItem[$k] = (string) $el;
                }
                $res[] = $dataItem;
                if (count($res) % self::BATCH_SIZE === 0) {
                    yield $res;
                    $res = [];
                }
            }
        }
        yield $res;
    }
}
