<?php

namespace App\Service;

/**
 * Renders parsed data as HTML table.
 */
class TableRenderer
{
    /**
     * Builds HTML table from data.
     *
     * @param array<int, array<string, mixed>> $rows
     * @return string
     */
    public function render(array $rows)
    {
        if (empty($rows)) {
            return '<p class="empty">Duomenų nerasta arba failas neteisingas.</p>';
        }

        // Union headers from all rows to be robust to heterogeneous data
        $headers = [];
        foreach ($rows as $row) {
            foreach (array_keys($row) as $key) {
                if (!in_array($key, $headers, true)) {
                    $headers[] = $key;
                }
            }
        }

        $html = '<div class="table-wrapper">';
        $html .= '<table>';
        $html .= '<thead><tr>';

        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars($header, ENT_QUOTES, 'UTF-8') . '</th>';
        }

        $html .= '</tr></thead>';
        $html .= '<tbody>';

        foreach ($rows as $row) {
            $html .= '<tr>';

            foreach ($headers as $header) {
                $value = isset($row[$header]) ? $row[$header] : '';
                $html .= '<td>' . htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8') . '</td>';
            }

            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';

        return $html;
    }
}
