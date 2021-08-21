<?php

namespace pcb\api\category;

require_once '../controllers/CategoryController.php';
require_once 'Api.php';

use pcb\controllers\CategoryController;
use pcb\api\Api;

class ApiCategory extends Api {

    public function getJsonCategoryList(): string {
        $controller = new CategoryController();
        $categoryList = $controller->getList();

        if ($categoryList != null) {
            $wrappedArr = parent::toWrapObjList($categoryList);

            return parent::prepareDataToSendClient($wrappedArr);
        }

        return parent::prepareDataToSendClient(array('message' => 'Categories not found.'));
    }

    public function getJsonSingleCategory(int $id): string {
        $controller = new CategoryController();
        $category = $controller->get($id);

        if (!empty($category->id)) {
            $dataArr = array();
            $dataArr['data'] = parent::putDataToArray($category);

            return parent::prepareDataToSendClient($dataArr);
        }

        return parent::prepareDataToSendClient(array('message' => 'No Category found with this id.'));
    }

    public function setJsonCategory(string $jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);
        $controller = new CategoryController();

        if ($controller->create($dataArr)) {
            return json_encode(Array('message' => 'New Category was created.'));
        }

        return json_encode(Array('message' => 'Category was not created.'));
    }

    public function updateJsonCategory(string $jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);
        $controller = new CategoryController();

        if ($controller->update($dataArr)) {
            return json_encode(Array('message' => 'Category was updated.'));
        }

        return json_encode(Array('message' => 'Category was not updated.'));
    }

    public function deleteJsonCategory(string $jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);
        $controller = new CategoryController();

        if ($controller->delete($dataArr)) {
            return json_encode(Array('message' => 'Category was deleted.'));
        }

        return json_encode(Array('message' => 'Category was not deleted.'));
    }

}