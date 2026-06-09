<?php

namespace App\Parser;

/**
 * Parses XML files.
 */
class XmlParser implements FileParserInterface
{
    /**
     * Parses XML file into associative array.
     *
     * @param string $filePath
     * @return array<int, array<string, mixed>>
     */
    public function parse($filePath)
    {
        libxml_use_internal_errors(true);

        $xml = simplexml_load_file($filePath, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($xml === false) {
            $messages = [];
            foreach (libxml_get_errors() as $e) {
                $messages[] = $e->message;
            }
            libxml_clear_errors();
            throw new \RuntimeException('XML parsavimo klaida: ' . implode('; ', $messages));
        }

        $rows = [];
        foreach ($xml->item as $item) {
            $row = [];
            foreach ($item->children() as $key => $value) {
                $row[$key] = (string) $value;
            }
            $rows[] = $row;
        }

        return $rows;
    }
}
