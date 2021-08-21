<?php

namespace pcb\api;

require_once 'ApiCatalogItem.php';

use pcb\api\item\ApiCatalogItem;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$item_id = empty($_GET['id']) ? die() : $_GET['id'];

$apiSingleItem = new ApiCatalogItem();
echo $apiSingleItem->getJsonSingleItem((int)$item_id);