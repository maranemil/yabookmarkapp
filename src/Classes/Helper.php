<?php

namespace App\Classes;

class Helper
{
    /**
     * sanitizeString
     *
     * @param string $input
     * @return string
     */
    public static function sanitizeString(string $input): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $input);
    }

    /**
     * sanitizeInteger
     *
     * @param int $input
     * @return int
     * @noinspection PhpUnused
     */
    public static function sanitizeInteger(int $input): int
    {
        return $input;
    }

    /**
     * sanitizeUrl
     *
     * @param $input
     * @return string
     */
    public static function sanitizeUrl($input): string
    {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }
}
