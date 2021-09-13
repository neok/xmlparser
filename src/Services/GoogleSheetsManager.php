<?php

namespace App\Services;

use Google\Service\Sheets;

/**
 * Class GoogleSheetsManager
 */
class GoogleSheetsManager
{
    /**
     * @var Sheets
     */
    private $service;

    /**
     * @param Sheets $service
     */
    public function __construct(Sheets $service)
    {
        $this->service = $service;
    }

    /**
     * @param array $objects
     * @param string $sheetId
     *
     * @return Sheets\BatchUpdateValuesResponse
     */
    public function batchUpdate(array $objects, string $sheetId): Sheets\BatchUpdateValuesResponse
    {
        $request = new \Google_Service_Sheets_BatchUpdateValuesRequest();
        $request->setValueInputOption('RAW');
        $request->setData($objects);

        return $this->service->spreadsheets_values->batchUpdate($sheetId, $request);
    }

    /**
     * @param array $values
     * @param int $itemNumber
     *
     * @return \Google_Service_Sheets_ValueRange
     */
    public function createValueRange(array $values, int $itemNumber): \Google_Service_Sheets_ValueRange
    {
        $valueRange = new \Google_Service_Sheets_ValueRange();
        $valueRange->setRange("A" . $itemNumber . ":Z900");
        $valueRange->setValues([$values]);

        return $valueRange;
    }
}
