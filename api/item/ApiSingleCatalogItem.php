<?php

namespace pcb\api\item;

include_once 'ApiCatalogItem.php';
include_once '../controllers/SingleCatalogItemController.php';

use pcb\controllers\SingleCatalogItemController;

class ApiSingleCatalogItem extends ApiCatalogItem {

    public function __construct() {
        parent::__construct();
    }

    /** Вызывается при отправке данных отдельного CatalogItem */
    public function getJsonSingleItem($id): string {
        $controller = new SingleCatalogItemController();
        $item = $controller->getSingleItem($id);

        $obj_arr = parent::putDataToArray($item);

        return parent::prepareDataToSendClient($obj_arr);

    }

    /** Вызывается при создании клиентом нового CatalogItem */
    public function setJsonSingleItem($jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);

        $controller = new SingleCatalogItemController();

        if ($controller->createSingleItem($dataArr)) {
            return json_encode(Array('message' => 'New Catalog Item was created.'));
        }

        return json_encode(Array('message' => 'Catalog Item was not created.'));
    }

    public function updateJsonSingleItem($jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);

        $controller = new SingleCatalogItemController();

        if ($controller->updateSingleItem($dataArr)) {
            return json_encode(Array('message' => 'Catalog Item was updated.'));
        }

        return json_encode(Array('message' => 'Catalog Item was not updated.'));

    }

    public function deleteJsonSingleItem($jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);

        $controller = new SingleCatalogItemController();

        if ($controller->deleteSingleItem($dataArr)) {
            return json_encode(Array('message' => 'Catalog Item was deleted.'));
        }

        return json_encode(Array('message' => 'CatalogItem was not deleted.'));
    }

}