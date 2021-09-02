<?php

namespace pcb\api;

require_once '../vendor/autoload.php';

use pcb\api\item\ApiCatalogItem;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$rawUpdateData = file_get_contents('php://input');

$apiSingleItem = new ApiCatalogItem();
echo $apiSingleItem->updateJsonSingleItem($rawUpdateData);