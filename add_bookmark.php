<?php

include_once "config/settings.php";
include_once "src/Controller/AppController.php";

try {
    $o = new AppController();
    $o->addBookmark();  

} catch (Exception $e) {
    echo $e->getMessage();
}
