<?php

namespace App\Services\Loader;

use App\Dto\GoogleSheetItemDto;
use App\Services\GoogleSheetsManager;
use Psr\Log\LoggerAwareTrait;

/**
 * Class GoogleLoader
 */
class GoogleLoader implements LoaderInterface
{
    use LoggerAwareTrait;

    /**
     * @var GoogleSheetsManager
     */
    protected $manager;

    /**
     * @var int
     */
    protected $num = 1;

    /**
     * @param GoogleSheetsManager $manager
     */
    public function __construct(GoogleSheetsManager $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @param GoogleSheetItemDto[] $data
     *
     * @return mixed|void
     */
    public function load(array $data, string $destination)
    {
        $objects = [];
        foreach ($data as $dto) {
            $this->num++;
            $objects[] = $this->manager->createValueRange($dto->getDataItem(), $this->num);
        }

        sleep(2);
        try {
            $this->manager->batchUpdate($objects, $destination);

        } catch (\Exception $e) {
            $this->logger->error('Batch update error', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

}
