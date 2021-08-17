<?php

namespace pcb\api\category;

include_once '../controllers/CategoryController.php';
include_once 'Api.php';

use pcb\controllers\CategoryController;
use pcb\api\Api;

class ApiCategory extends Api {

    public function getJsonCategoryList(): array {
        $controller = new CategoryController();
        $categoryList = $controller->getCategoryList();

        $dataArr = array();
        $dataArr['data'] = array();

        foreach ($categoryList as $category) {
            array_push($dataArr['data'], parent::putDataToArray($category));
        }

        return $dataArr;
    }

}