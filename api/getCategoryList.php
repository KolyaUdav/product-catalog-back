<?php

namespace pcb\api;

include_once('category/ApiCategory.php');

use pcb\api\category\ApiCategory;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$apiCategory = new ApiCategory();
echo $apiCategory->getJsonCategoryList();