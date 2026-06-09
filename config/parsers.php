<?php

use App\Parser\CsvParser;
use App\Parser\JsonParser;
use App\Parser\XmlParser;

return [
    'csv' => CsvParser::class,
    'json' => JsonParser::class,
    'xml' => XmlParser::class,
];
