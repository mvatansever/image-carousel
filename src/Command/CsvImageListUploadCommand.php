<?php

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class CsvImageListUploadCommand extends Command
{
    private const FILE_PATH = 'filePath';

    protected static $defaultName = 'image-list:csv-upload';

    public function __construct(
        private LoggerInterface $logger,
        private Filesystem $filesystem,
        private ParameterBagInterface $params
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Uploading the CSV file into our system to filter the data later on.')
             ->addArgument(
                 self::FILE_PATH,
                 InputArgument::REQUIRED,
                 'Full file path of the CSV file which includes image list.'
             );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument(self::FILE_PATH);

        try {
            if (!is_file($filePath)) {
                throw new \RuntimeException('File path is not correct.');
            }
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            if (strtolower($extension) != 'csv') {
                throw new \RuntimeException('File should be in CSV type.');
            }

            $dataFolder = sprintf('%s/%s/%s', $this->params->get('kernel.project_dir'), 'data', 'latest.csv');
            $this->filesystem->copy($filePath, $dataFolder);

            $output->writeln('<info>The CSV file successfully uploaded to our system.</info>');
        } catch (\RuntimeException $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            $this->logger->warning($e->getMessage());

            throw $e;
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            $this->logger->error(sprintf('image-list:csv-upload command error. Message : % --- trace: %s', $e->getMessage(), $e->getTraceAsString()));

            throw $e;
        }

        return 0;
    }
}