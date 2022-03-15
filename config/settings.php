<?php /** @noinspection PhpUnused */
/** @noinspection PhpIncludeInspection */

ini_set('error_reporting', 1);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('log_errors', 1);
ini_set("error_log", "/home/" . get_current_user() . "/Web/yabookmarkapp/php-error.log");

ini_set('max_execution_time', 30);
#ini_set('memory_limit', '250M'); 

// set global app dir
$APP_ROOT_YBMA = str_replace(basename(__DIR__), "", __DIR__);
define('APP_ROOT_YBMA', $APP_ROOT_YBMA);

require_once APP_ROOT_YBMA . '/vendor/autoload.php';

/**
 * settings
 */
const APP_TEMPLATES_PATH = '../Templates/';

/**
 * Smarty
 */
include_once('Smarty.class.php');

/**
 *  include App Classes
 */
$arrAppclasses = [
    'Database.php',
    'Categories.php',
    'Bookmarks.php',
    'Favourites.php',
    'Helper.php'
];
foreach ($arrAppclasses as $sClass) {
    include_once("src/Classes/$sClass");
}
