<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once 'item/ApiSingleCatalogItem.php';
include_once '../config/Database.php';

$item_id = isset($_GET['id']) ? $_GET['id'] : die();

$apiSingleItem = new ApiSingleCatalogItem();
echo $apiSingleItem->getJsonSingleItem($item_id);