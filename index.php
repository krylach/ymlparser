<?php
use Krylach\YMLParser\YML;

require_once("./vendor/autoload.php");

$yml = new YML("158.xml");

$start = microtime(true);
$yml = $yml->parse(true);

    
// }
// $shop = $yml->getShop();
// $categories = $yml->getCategories();
// dump($shop, $categories, $yml->getOffers(),$yml->getCurrencies());
echo 'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';
