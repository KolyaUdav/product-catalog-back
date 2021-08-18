<?php

namespace pcb\api\category;

include_once '../controllers/CategoryController.php';
include_once 'Api.php';

use pcb\controllers\CategoryController;
use pcb\api\Api;

class ApiCategory extends Api {

    public function getJsonCategoryList(): string {
        $controller = new CategoryController();
        $categoryList = $controller->getList();

        $dataArr = array();
        $dataArr['data'] = array();

        foreach ($categoryList as $category) {
            array_push($dataArr['data'], parent::putDataToArray($category));
        }

        return parent::prepareDataToSendClient($dataArr);
    }

    public function getjsonSingleCategory($id): string {
        $controller = new CategoryController();
        $category = $controller->get($id);

        $dataArr = array();
        $dataArr['data'] = parent::putDataToArray($category);

        return parent::prepareDataToSendClient($dataArr);
    }

    public function setJsonCategory($jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);
        $controller = new CategoryController();

        if ($controller->create($dataArr)) {
            return json_encode(Array('message' => 'New Category was created.'));
        }

        return json_encode(Array('message' => 'Category was not created.'));
    }

    public function updateJsonCategory($jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);
        $controller = new CategoryController();

        if ($controller->update($dataArr)) {
            return json_encode(Array('message' => 'Category was updated.'));
        }

        return json_encode(Array('message' => 'Category was not updated.'));
    }

    public function deleteJsonCategory($jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);
        $controller = new CategoryController();

        if ($controller->delete($dataArr)) {
            return json_encode(Array('message' => 'Category was deleted.'));
        }

        return json_encode(Array('message' => 'Category was not deleted.'));
    }

}