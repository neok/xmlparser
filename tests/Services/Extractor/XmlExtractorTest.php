<?php

namespace Test\Services\Extractor;

use Monolog\Test\TestCase;

class XmlExtractorTest extends TestCase
{

    public function testExtract()
    {
        $extractor = new \App\Services\Extractor\XmlExtractor();
        foreach ($extractor->extract(__DIR__. '/file.xml', 'PLANT') as $plants) {
            static::assertIsArray($plants);
            foreach ($plants as $plant) {
                //todo add more asserts
                static::assertArrayHasKey('BOTANICAL', $plant);
                static::assertArrayHasKey('ZONE', $plant);
            }

        }
    }
}