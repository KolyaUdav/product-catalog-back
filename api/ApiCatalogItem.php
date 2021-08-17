<?php

namespace pcb\api\item;

require_once 'Api.php';
require_once '../controllers/CatalogItemController.php';

use pcb\controllers\CatalogItemController;
use pcb\Api\Api;

class ApiCatalogItem extends Api {

    /** Вызывается при отправке данных отдельного CatalogItem */
    public function getJsonSingleItem($id): string {
        $controller = new CatalogItemController();
        $item = $controller->get($id);

        $obj_arr = array();
        $obj_arr['data'] = parent::putDataToArray($item);
        return parent::prepareDataToSendClient($obj_arr);

    }

    /** Вызывается при создании клиентом нового CatalogItem */
    public function setJsonSingleItem($jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);

        $controller = new CatalogItemController();

        if ($controller->create($dataArr)) {
            return json_encode(Array('message' => 'New Catalog Item was created.'));
        }

        return json_encode(Array('message' => 'Catalog Item was not created.'));
    }

    public function updateJsonSingleItem($jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);

        $controller = new CatalogItemController();

        if ($controller->update($dataArr)) {
            return json_encode(Array('message' => 'Catalog Item was updated.'));
        }

        return json_encode(Array('message' => 'Catalog Item was not updated.'));

    }

    public function deleteJsonSingleItem($jsonString): string {
        $dataArr = parent::jsonToAssocArray($jsonString);

        $controller = new CatalogItemController();

        if ($controller->delete($dataArr)) {
            return json_encode(Array('message' => 'Catalog Item was deleted.'));
        }

        return json_encode(Array('message' => 'CatalogItem was not deleted.'));
    }

    public function getJsonCatalogItemList(): string {
        $controller = new CatalogItemController();
        $list = $controller->getList();

        if ($list !== null) {
            $wrapped_arr = $this->toWrapCatalogItemList($list);

            return parent::prepareDataToSendClient($wrapped_arr);
        }

        return parent::prepareDataToSendClient(Array('message' => 'No objects found.'));
    }

    private function toWrapCatalogItemList($list): array {
        $obj_arr = Array();
        $obj_arr['data'] = Array();

        foreach ($list as $obj) {
            /** Данные объекта пакуем в ассоц. массив, затем добавляем его в массив obj_arr[data] */

            array_push($obj_arr['data'], parent::putDataToArray($obj));
        }

        return $obj_arr;
    }

}