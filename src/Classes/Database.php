<?php


use voku\db\DB;

class Database
{
    public static function init()
    {
        return DB::getInstance('localhost', 'abc', 'abc', 'yabookmarkapp');
    }
}