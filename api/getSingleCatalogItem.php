<?php

namespace pcb\api;

include_once('item/ApiSingleCatalogItem.php');

use pcb\api\item\ApiSingleCatalogItem;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$item_id = $_GET['id'] ?? die();

$apiSingleItem = new ApiSingleCatalogItem();
echo $apiSingleItem->getJsonSingleItem($item_id);