<?php

namespace pcb\api;

include_once('item/ApiCatalogItemList.php');

use pcb\api\item\ApiCatalogItemList;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$apiItemList = new ApiCatalogItemList();
echo $apiItemList->getJsonCatalogItemList();