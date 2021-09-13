<?php

namespace App\Services\Transformer;

use App\Dto\GoogleSheetItemDto;

/**
 * Class DtoTransformer
 */
class DtoTransformer implements DataTransformerInterface
{
    /**
     * @param $array
     *
     * @return GoogleSheetItemDto[]
     */
    public function fromArray($array): array
    {
        return array_map(static function ($item) {
            return new GoogleSheetItemDto(array_values($item));
        }, $array);
    }
}
