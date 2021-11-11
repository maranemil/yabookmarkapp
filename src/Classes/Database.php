<?php

namespace App\Classes;
use voku\db\DB;

class Database
{
    public static function init(): DB
    {
        return DB::getInstance(
            'localhost',
            'blabla',
            'blabla',
            'yabookmarkapp'
        );
    }
}
