<?php

namespace pcb\api;

require_once 'ApiCategory.php';

use pcb\api\category\ApiCategory;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$apiCategory = new ApiCategory();
echo $apiCategory->getJsonCategoryList();