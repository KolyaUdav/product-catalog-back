<?php

namespace pcb\api;

require_once 'ApiCatalogItem.php';

use pcb\api\item\ApiCatalogItem;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$category_id = empty($_GET['category_id']) ? die() : $_GET['category_id'];

$apiListByCategory = new ApiCatalogItem();
echo $apiListByCategory->getJsonListByCategory((int)$category_id);