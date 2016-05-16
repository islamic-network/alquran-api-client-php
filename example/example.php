<?php
require_once ('../../../../vendor/autoload.php');

use AlQuranCloud\ApiClient\Client;

$client = new Client;

$editions = $client->editions();

foreach ($editions->data as $d) {
    echo $d->englishName . "\n";
}