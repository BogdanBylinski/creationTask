<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Controller\FileUploadController;
use App\Factory\ParserFactory;
use App\Service\FileValidator;
use App\Service\TableRenderer;
use App\View\View;

$parserConfig = require __DIR__ . '/../config/parsers.php';

$controller = new FileUploadController(
    new FileValidator(array_keys($parserConfig)),
    new ParserFactory($parserConfig),
    new TableRenderer(),
    new View()
);

$controller->handle();
