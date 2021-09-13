<?php

namespace Test\Services;

use App\Services\XmlFileManager;
use Monolog\Test\TestCase;

class XmlFileManagerTest extends TestCase
{

    public function testIsValid()
    {
        //todo add invalid file test
        $manager = new XmlFileManager();
        static::assertEquals(true, $manager->isValid(__DIR__.'/Extractor/file.xml'));
    }

}