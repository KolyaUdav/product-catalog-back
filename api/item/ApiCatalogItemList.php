<?php

include_once 'ApiCatalogItem.php';
include_once '../controllers/CatalogItemListController.php';

class ApiCatalogItemList extends ApiCatalogItem {

    public function __construct() {
        parent::__construct();
    }

    public function getJsonCatalogItemList() {
        $controller = new CatalogItemListController();
        $list = $controller->getList();

        if ($list !== null) {
            $wrapped_arr = $this->toWrapCatalogItemList($list);
        
            return parent::prepareDataToSendClient($wrapped_arr);
        }

        return parent::prepareDataToSendClient(Array('message' => 'No objects found.'));
    }

    private function toWrapCatalogItemList($list) {
        $obj_arr = Array();
        $obj_arr['data'] = Array();

        foreach ($list as $obj) {
            /** Данные объекта пакуем в ассоц. массив, затем добавляем его в массив obj_arr[data] */

            /** FROM SUPER */
            array_push($obj_arr['data'], parent::putDataToArray($obj));
        }

        return $obj_arr;
    }

}

