<?php

include_once "config/settings.php";
include_once "src/Controller/AppController.php";

try {
    $o = new AppController();
    $o->favourites();
} catch (Exception $e) {
    echo $e->getMessage();
}

echo $jaxon->getJs();
echo $jaxon->getScript();
echo $jaxon->getCss();