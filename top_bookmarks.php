<?php

use App\AppController;
use Jaxon\Jaxon;

include_once "config/settings.php";

try {
    $o = new AppController();
    $o->topBookmarks();
} catch (Exception $e) {
    echo $e->getMessage();
}
$jaxon = new Jaxon();
echo $jaxon->getJs();
echo $jaxon->getScript();
echo $jaxon->getCss();