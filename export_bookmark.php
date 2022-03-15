<?php

use App\AppController;

include_once "config/settings.php";

try {
    $o = new AppController();
    $o->exportBookmarks();
} catch (Exception $e) {
    echo $e->getMessage();
}
