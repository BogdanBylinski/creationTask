<?php

namespace App\Service;

/**
 * Validates uploaded files.
 */
class FileValidator
{
    /**
     * @var array<int, string>
     */
    private $allowedExtensions;

    /**
     * @param array<int, string> $allowedExtensions
     */
    public function __construct(array $allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    /**
     * Validates uploaded file.
     *
     * @param array<string, mixed> $file
     * @return array<int, string>
     */
    public function validate(array $file)
    {
        $errors = [];

        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Failas nebuvo sėkmingai įkeltas.';
            return $errors;
        }

        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            $errors[] = 'Netinkamas laikinas failas.';
            return $errors;
        }

        if (!isset($file['name']) || trim($file['name']) === '') {
            $errors[] = 'Failo pavadinimas neteisingas.';
            return $errors;
        }

        if (!isset($file['size']) || (int)$file['size'] <= 0) {
            $errors[] = 'Failas yra tuščias.';
        }

        // Maksimalus dydis: 2 MB (galima iškelti į konfigą, jei reikės)
        $maxSize = 2 * 1024 * 1024;
        if (isset($file['size']) && (int)$file['size'] > $maxSize) {
            $errors[] = 'Failas per didelis (maks. 2 MB).';
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions, true)) {
            $errors[] = 'Nepalaikomas failo formatas. Leidžiama: ' . implode(', ', $this->allowedExtensions) . '.';
        }

        return $errors;
    }
}
