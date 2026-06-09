<?php

namespace App\Parser;

/**
 * Parses CSV files.
 */
class CsvParser implements FileParserInterface
{
    /**
     * Parses CSV file into associative array.
     *
     * @param string $filePath
     * @return array<int, array<string, mixed>>
     */
    public function parse($filePath)
    {
        $rows = [];
        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            return [];
        }

        $headers = null;

        while (($data = fgetcsv($handle, 0, ',', "'")) !== false) {
            if ($headers === null) {
                $headers = $data;
                continue;
            }

            if (count($headers) === count($data)) {
                $rows[] = array_combine($headers, $data);
            }
        }

        fclose($handle);

        return $rows;
    }
}
