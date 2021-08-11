<?php

namespace pcb\controllers;

include_once('../config/Database.php');
include_once('../models/CatalogItem.php');

use pcb\config\Database;
use pcb\models\CatalogItem;

class CatalogItemController {

    protected $conn;

    const TABLE = 'items';

    protected function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    protected function dataToObject(Array $dataArr): CatalogItem {
        $cleanedDataArr = $this->cleanData($dataArr);

        return $this->createCatalogItemObject($cleanedDataArr);
    }

    private function cleanData(Array $dataArr): array {
        $cleanedDataArr = Array();

        foreach ($dataArr as $data) {
            $clean_data = htmlspecialchars(strip_tags($data));
            $key = array_search($data, $dataArr);
            $cleanedDataArr[$key] = $clean_data;
        }

        return $cleanedDataArr;
    }

    private function createCatalogItemObject(Array $dataArr): CatalogItem {
        $catalogItem = new CatalogItem();

        $properties = array_keys($this->getPublicProperties($catalogItem)); // Получаем все public properties
        
        foreach ($properties as $prop) {
            if (array_key_exists($prop, $dataArr)) {
                /** Используем метод для автоматического присваивания value необходимым свойствам */
                $catalogItem->addValueToProperty($prop, $dataArr[$prop]);
            }
        }

        return $catalogItem;
    }

    private function getPublicProperties($catalogItem): array {
        return get_object_vars($catalogItem);
    }

}