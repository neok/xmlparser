<?php

namespace Test\Services\Transformer;

use App\Dto\GoogleSheetItemDto;
use App\Services\Transformer\DtoTransformer;
use Monolog\Test\TestCase;

class DtoTransformerTest extends TestCase
{
    /**
     * @param $data
     * @param $expected
     * @dataProvider dataProvider
     */
    public function testFromArray($data, $expected)
    {
        $transformer = new DtoTransformer();

        foreach ($transformer->fromArray($data) as $item) {
            static::assertEquals($item->getDataItem(), $expected);
        }
    }

    public function dataProvider(): array
    {
        return [
            [
                [[11 => 11, 22 => 22]], [11, 22],
            ],
            [
                [[1, 2, 3, 4]], [1, 2, 3, 4]
            ]
        ];
    }

}