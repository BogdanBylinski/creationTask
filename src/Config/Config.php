<?php

namespace App\Config;

/**
 * Minimal Config holder (placeholder for future settings).
 */
class Config
{
    /**
     * Returns application base path.
     *
     * @return string
     */
    public static function basePath()
    {
        return dirname(__DIR__, 2);
    }
}
