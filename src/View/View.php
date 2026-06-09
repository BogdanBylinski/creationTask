<?php

namespace App\View;

/**
 * Simple view renderer.
 */
class View
{
    /**
     * Renders PHP view file.
     *
     * @param string $view
     * @param array<string, mixed> $data
     * @return void
     */
    public function render($view, array $data = [])
    {
        extract($data);

        require __DIR__ . '/../../views/' . $view . '.php';
    }
}
