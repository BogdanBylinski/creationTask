<?php

namespace App\Factory;

use App\Parser\FileParserInterface;

/**
 * Creates parser instances by file extension.
 */
class ParserFactory
{
    /**
     * @var array<string, string>
     */
    private $parsers;

    /**
     * @param array<string, string> $parsers
     */
    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }

    /**
     * Creates parser by extension.
     *
     * @param string $extension
     * @return FileParserInterface
     */
    public function create($extension)
    {
        if (!isset($this->parsers[$extension])) {
            throw new \InvalidArgumentException('Nepalaikomas failo formatas.');
        }

        $parserClass = $this->parsers[$extension];
        if (!class_exists($parserClass)) {
            throw new \RuntimeException('Parserio klasė nerasta: ' . $parserClass);
        }

        $parser = new $parserClass();

        if (!$parser instanceof FileParserInterface) {
            throw new \RuntimeException('Parseris turi įgyvendinti FileParserInterface.');
        }

        return $parser;
    }
}
