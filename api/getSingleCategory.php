<?php

namespace pcb\api;

require_once 'ApiCategory.php';

use pcb\api\category\ApiCategory;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$category_id = empty($_GET['id']) ? die() : $_GET['id'];

$apiCategory = new ApiCategory();
echo $apiCategory->getjsonSingleCategory((int)$category_id);