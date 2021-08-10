<?php

include_once 'ApiCatalogItem.php';
include_once '../controllers/SingleCatalogItemController.php';

class ApiSingleCatalogItem extends ApiCatalogItem {

    public function __construct() {
        parent::__construct();
    }

    /** Вызывается при отправке данных отдельного CatalogItem */
    public function getJsonSingleItem($id) {
        $controller = new SingleCatalogItemController();
        $item = $controller->getSingleItem($id);

        /** FROM SUPER */
        $obj_arr = parent::putDataToArray($item);

        /** FROM SUPER */
        return parent::prepareDataToSendClient($obj_arr);

    }

    /** Вызывается при создании клиентом нового CatalogItem */
    public function setJsonSingleItem($jsonString) {
        $dataArr = parent::jsonToAssocArray($jsonString);

        $controller = new SingleCatalogItemController();

        if ($controller->createSingleItem($dataArr)) {
            return json_encode(Array('message' => 'New Catalog Item was created.'));
        }

        return json_encode(Array('message' => 'Catalog Item was not created.'));
    }

    public function updateJsonSingleItem($jsonString) {
        $dataArr = parent::jsonToAssocArray($jsonString);

        $controller = new SingleCatalogItemController();

        if ($controller->updateSingleItem($dataArr)) {
            return json_encode(Array('message' => 'Catalog Item was updated.'));
        }

        return json_encode(Array('message' => 'Catalog Item was not updated.'));

    }

    public function deleteJsonSingleItem($jsonString) {
        $dataArr = parent::jsonToAssocArray($jsonString);

        $controller = new SingleCatalogItemController();

        if ($controller->deleteSingleItem($dataArr)) {
            return json_encode(Array('message' => 'Catalog Item was deleted.'));
        }

        return json_encode(Array('message' => 'CatalogItem was not deleted.'));
    }

}