<?php

namespace App\Dto;

class GoogleSheetItemDto
{
    /**
     * @var array
     */
    protected $dataItem;

    /**
     * @param array $dataItem
     */
    public function __construct(array $dataItem)
    {
        $this->dataItem = $dataItem;
    }

    public function getDataItem(): array
    {
        return $this->dataItem;
    }
}
