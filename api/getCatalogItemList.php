<?php

namespace pcb\api;

require_once 'ApiCatalogItem.php';

use pcb\api\item\ApiCatalogItem;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$apiItemList = new ApiCatalogItem();
echo $apiItemList->getJsonCatalogItemList();