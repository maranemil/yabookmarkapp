<?php

use App\AppController;

include_once "config/settings.php";

try {
    $o = new AppController();
    $o->editBookmark();
} catch (Exception $e) {
    echo $e->getMessage();
}
