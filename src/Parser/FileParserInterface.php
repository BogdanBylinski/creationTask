<?php

namespace App\Parser;

/**
 * Interface for all file parsers.
 */
interface FileParserInterface
{
    /**
     * Parses uploaded file content into table rows.
     *
     * @param string $filePath
     * @return array<int, array<string, mixed>>
     */
    public function parse($filePath);
}
