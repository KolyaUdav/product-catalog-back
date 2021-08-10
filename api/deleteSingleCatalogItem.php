<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'item/ApiSingleCatalogItem.php';

$rawDeleteData = file_get_contents('php://input');

$apiSingleItem = new ApiSingleCatalogItem();
echo $apiSingleItem->deleteJsonSingleItem($rawDeleteData);