<?php

use App\AppController;

include_once "config/settings.php";
include_once "src/Classes/Bookmarks.php";

try {
    $o = new AppController();
    $o->addBookmark();
} catch (Exception $e) {
    echo $e->getMessage();
}
