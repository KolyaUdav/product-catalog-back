<?php

namespace pcb\api;

require_once 'ApiCatalogItem.php';

use pcb\api\item\ApiCatalogItem;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$item_id = $_GET['id'] ?? die();

$apiSingleItem = new ApiCatalogItem();
echo $apiSingleItem->getJsonSingleItem($item_id);