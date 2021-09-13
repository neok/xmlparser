<?php

namespace Test\Services\Loader;

use App\Dto\GoogleSheetItemDto;
use App\Services\GoogleSheetsManager;
use App\Services\Loader\GoogleLoader;
use Google\Service\Sheets\BatchUpdateValuesResponse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class GoogleLoaderTest extends TestCase
{
    /**
     * @var GoogleSheetsManager|MockObject
     */
    protected $manager;

    /**
     * @var LoggerInterface|MockObject
     */
    protected $logger;

    public function setUp()
    {
        $this->logger = new NullLogger();
        $this->manager = $this->createMock(GoogleSheetsManager::class);
    }

    /**
     * @param $data
     * @param $destination
     * @dataProvider dataProvider
     */
    public function testLoad($data, $destination)
    {
        $range = new \Google_Service_Sheets_ValueRange();
        $this->manager->expects(self::once())
            ->method('createValueRange')
            ->withConsecutive([[1,2,3], 1])
            ->willReturn($range);

        $this->manager->expects(self::once())
            ->method('batchUpdate')
            ->withConsecutive([[$range], $destination])
            ->willReturn(new BatchUpdateValuesResponse());

        $loader = new GoogleLoader($this->manager, $this->logger);

        $loader->load($data, $destination);
    }

    public function dataProvider()
    {
        return [
         [[new GoogleSheetItemDto([1,2,3])], 'somewhere']
        ];
    }

}