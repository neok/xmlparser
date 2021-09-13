<?php

namespace App\Commands;

use App\Services\Extractor\ExtractorInterface;
use App\Services\Extractor\XmlExtractor;
use App\Services\FileManager;
//use App\Services\GoogleClient;
use App\Services\Loader\LoaderInterface;
use App\Services\Transformer\DataTransformerInterface;
use App\Services\XmlFileManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Google\Client;

class ParseXmlCommand extends Command
{
    protected static $defaultName = 'app:parse-xml';
    /**
     * @var FileManager
     */
    private $fileManager;

    private $pathToFile;

    /**
     * @var ExtractorInterface
     */
    private $extractor;

    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @var DataTransformerInterface
     */
    private $transformer;
    /**
     * @var Client
     */
    private $googleClient;

    public function __construct(
        string $name = null,
        XmlFileManager $fileManager,
        ExtractorInterface $extractor,
        LoaderInterface $loader,
        DataTransformerInterface $dataTransformer,
        Client $googleClient
    ) {
        $this->fileManager = $fileManager;
        $this->extractor = $extractor;
        $this->loader = $loader;
        $this->transformer = $dataTransformer;
        $this->googleClient= $googleClient;
        parent::__construct($name);
    }


    protected function configure(): void
    {
        $this
            ->setDescription('Parse xml file.')
            ->setHelp('Parse xml file(local or remote), transform and store in google sheets.')
            ->addArgument('file', InputArgument::REQUIRED, 'Path to file(local or remote)')
            ->addArgument('node_type', InputArgument::REQUIRED, 'Which node to parse')
            ->addArgument('google_sheet_id', InputArgument::REQUIRED, 'Google sheet id')
            ->addArgument('google_config', InputArgument::REQUIRED, 'Path to google config(json format)');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        $url = filter_var($file, FILTER_VALIDATE_URL);
        if ($url) {
            $this->pathToFile = $this->fileManager->downloadFile($url);
            if (!$this->pathToFile || !$this->fileManager->isValid($this->pathToFile)) {
                throw new \RuntimeException('Something went wrong while trying to download the file.');
            }
        } else {
            $this->pathToFile = $file;
            if (!is_file($file) || !$this->fileManager->isValid($file)) {
                throw new \InvalidArgumentException('File does not exists');
            }
        }
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($config = $input->getArgument('google_config')) {

            $this->googleClient->setAuthConfig($config);
        }
        $progress = new ProgressBar($output);
        $progress->setFormat('verbose');
        $progress->start();
//        $fileName = __DIR__ . '/../../data/coffee_feed.xml';
//        $fileName = __DIR__ . '/../../data/file_613c4c75a13a54.37883187';
//        $id = '1cTwceK2LHJlss3LjDbEWInueDeOUsFP3dSNsT5EqK1E';

        foreach ($this->extractor->extract($this->pathToFile, $input->getArgument('node_type')) as $el) {
            $this->loader->load(
                $this->transformer->fromArray($el),
                $input->getArgument('google_sheet_id')
            );
            $progress->advance();
        }

        $progress->finish();
        return Command::SUCCESS;
    }
}
