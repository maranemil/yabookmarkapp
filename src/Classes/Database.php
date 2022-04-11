<?php

namespace App\Classes;

use voku\db\DB;

class Database
{
    public static function init(): DB
    {
        return DB::getInstance(
            YBMA_APP_DB_HOST,
            YBMA_APP_DB_USER,
            YBMA_APP_DB_PASS,
            YBMA_APP_DB_NAME,
        );
    }
}
