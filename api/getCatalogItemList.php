<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once 'item/ApiCatalogItemList.php';
include_once '../config/Database.php';

$apiItemList = new ApiCatalogItemList();
echo $apiItemList->getJsonCatalogItemList();