<?php

use App\AppController;

include_once "config/settings.php";
#include_once "src/Controller/AppController.php";

try {
    $o = new AppController();
    $o->addCategory();  

} catch (Exception $e) {
    echo $e->getMessage();
}
