<?php

use App\AppController;

include_once "config/settings.php";

try {
    $o = new AppController();
    $o->topBookmarks();
} catch (Exception $e) {
    echo $e->getMessage();
}

echo $jaxon->getJs();
echo $jaxon->getScript();
echo $jaxon->getCss();