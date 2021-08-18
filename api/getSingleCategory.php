<?php

namespace pcb\api;

require_once 'ApiCategory.php';

use pcb\api\category\ApiCategory;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$category_id = $_GET['id'] ?? die();

$apiCategory = new ApiCategory();
echo $apiCategory->getjsonSingleCategory($category_id);