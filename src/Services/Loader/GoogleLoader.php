<?php

namespace App\Services\Loader;

use App\Dto\GoogleSheetItemDto;
use App\Services\GoogleSheetsManager;
use Psr\Log\LoggerInterface;


/**
 * Class GoogleLoader
 */
class GoogleLoader implements LoaderInterface
{

    /**
     * @var GoogleSheetsManager
     */
    protected $manager;

    /**
     * @var int
     */
    protected $num = 1;

    /**
     * @var LoggerInterface
     */
    protected $logger;


    public function __construct(GoogleSheetsManager $manager, LoggerInterface  $logger)
    {
        $this->manager = $manager;
        $this->logger = $logger;
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
            $objects[] = $this->manager->createValueRange($dto->getDataItem(), $this->num);
            $this->num++;
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
