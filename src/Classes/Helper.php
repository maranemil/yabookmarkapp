<?php

class Helper
{
    /**
     * sanitizeString
     *
     * @param  mixed $input
     * @return void
     */
    public static function sanitizeString($input)
    {
        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $input);
    }
    /**
     * sanitizeInteger
     *
     * @param  mixed $input
     * @return void
     */
    public static function sanitizeInteger($input)
    {
        return (int)$input;
    }

    /**
     * sanitizeUrl
     *
     * @return void
     */
    public static function sanitizeUrl($input)
    {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }
}
