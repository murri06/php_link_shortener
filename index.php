<?php

namespace Acme;
require_once 'vendor/autoload.php';

$link = new Link();
if ($link->generateLink()) {
    echo $link->getLinkShorter();
}
