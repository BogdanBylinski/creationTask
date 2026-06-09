<?php

namespace App\Parser;

/**
 * Parses JSON files.
 */
class JsonParser implements FileParserInterface
{
    /**
     * Parses JSON file into associative array.
     *
     * @param string $filePath
     * @return array<int, array<string, mixed>>
     */
    public function parse($filePath)
    {
        $content = file_get_contents($filePath);
        if ($content === false) {
            return [];
        }

        $data = json_decode($content, true);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('JSON parsavimo klaida: ' . json_last_error_msg());
        }

        return is_array($data) ? $data : [];
    }
}
