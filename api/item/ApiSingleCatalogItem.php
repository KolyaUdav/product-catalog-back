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
        $obj_arr = $this->putDataToArray($item);

        /** FROM SUPER */
        return $this->prepareDataToSendClient($obj_arr);

    }

    /** Вызывается при создании клиентом нового CatalogItem */
    public function setJsonSingleItem($jsonString) {
        $dataArr = json_decode($jsonString, true);

        $controller = new SingleCatalogItemController();

        if ($controller->createSingleItem($dataArr)) {
            return json_encode(Array('message' => 'New Catalog Item was created.'));
        }

        return json_encode(Array('message' => 'Catalog Item not created.'));
    }

}