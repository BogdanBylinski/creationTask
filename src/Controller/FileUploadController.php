<?php

namespace App\Controller;

use App\Factory\ParserFactory;
use App\Service\FileValidator;
use App\Service\TableRenderer;
use App\View\View;
use Exception;

/**
 * Handles file upload request.
 */
class FileUploadController
{
    /** @var FileValidator */
    private $validator;

    /** @var ParserFactory */
    private $parserFactory;

    /** @var TableRenderer */
    private $tableRenderer;

    /** @var View */
    private $view;

    /**
     * @param FileValidator $validator
     * @param ParserFactory $parserFactory
     * @param TableRenderer $tableRenderer
     * @param View $view
     */
    public function __construct(
        FileValidator $validator,
        ParserFactory $parserFactory,
        TableRenderer $tableRenderer,
        View          $view
    )
    {
        $this->validator = $validator;
        $this->parserFactory = $parserFactory;
        $this->tableRenderer = $tableRenderer;
        $this->view = $view;
    }

    /**
     * Processes request and renders response.
     *
     * @return void
     */
    public function handle()
    {
        $errors = [];
        $table = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $file = isset($_FILES['data_file']) ? $_FILES['data_file'] : null;

            if ($file === null) {
                $errors[] = 'Pasirinkite failą.';
            } else {
                $errors = $this->validator->validate($file);

                if (empty($errors)) {
                    try {
                        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        $parser = $this->parserFactory->create($extension);
                        $rows = $parser->parse($file['tmp_name']);
                        $table = $this->tableRenderer->render($rows);
                    } catch (Exception $e) {
                        $errors[] = $e->getMessage();
                    }
                }
            }
        }

        $this->view->render('upload', [
            'errors' => $errors,
            'table' => $table,
        ]);
    }
}
