<?php

namespace pcb\api;

include_once('ApiCatalogItem.php');

use pcb\api\item\ApiCatalogItem;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$apiItemList = new ApiCatalogItem();
echo $apiItemList->getJsonCatalogItemList();