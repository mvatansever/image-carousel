<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class ImageFilterService
{
    private const LIMIT = 3000;

    private \SplFileObject $fileHandler;

    public function __construct(
        private Filesystem $filesystem,
        private LoggerInterface $logger,
    )
    {

    }

    public function filter(string $filePath, ?string $name = null, ?int $discountPercent = null): array
    {
        $result = [];
        for ($data = $this->readFile($filePath); $data->valid();)
        {
            $chunkedResult = [];
            // This function purpose is limiting the fetching data amount from CSV
            // to prevent memory errors in case we can do search huge size of array
            foreach ($this->getLimitedResult($data) as $rows) {
                $chunkedResult[] = $rows;
            }
            $searchResult = $this->search($chunkedResult, $name, $discountPercent);
            $result = $searchResult ? array_merge($result, $searchResult) : $result;
        }

        return $result;
    }

    /**
     * Reading the CSV file and returning generator of result.
     *
     * @param string $filePath
     * @return \Generator|null
     */
    public function readFile(string $filePath): ?\Generator
    {
        if (! $this->filesystem->exists($filePath)) {
            throw new \RuntimeException("There is no any CSV file which uploaded to our system.");
        }

        try {
            $this->fileHandler = new \SplFileObject($filePath, 'r');
            $this->fileHandler->setFlags(\SplFileObject::READ_CSV);

            while (($data = $this->fileHandler->fgetcsv()) !== false) {
                yield $data;
            }

        } catch (\Exception $e) {
            $this->logger->warning($e->getMessage());

            return false;
        }
    }

    private function getLimitedResult(\Generator $data): \Generator
    {
        for ($i = 0; $i < self::LIMIT && $data->valid(); $data->next(), $i++) {
            yield $data->current();
        }
    }

    private function search(array $rows, ?string $name = null, ?int $discountPercent = null): array
    {
        if (is_null($name) && is_null($discountPercent)) {
            return $rows; // Return all rows when no criteria are provided
        }
    
        return array_filter($rows, function ($val) use ($name, $discountPercent) {
            $nameMatch = is_null($name) || str_contains($val[1], $name);
            $discountPercentMatch = is_null($discountPercent) || $val[3] == $discountPercent;
    
            return $nameMatch || $discountPercentMatch;
        });
    }
}
