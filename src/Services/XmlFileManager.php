<?php

namespace App\Services;

use XMLReader;

/**
 * Class XmlFileManager
 */
class XmlFileManager extends FileManager
{

    /**
     * @param string $file
     *
     * @return bool
     */
    public function isValid(string $file): bool
    {
        /** @var XMLReader $xml */
        $xml = XMLReader::open($file);

        $xml->setParserProperty(XMLReader::VALIDATE, true);

        return $xml->isValid();
    }
}
