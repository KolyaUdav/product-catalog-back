<?php

include_once 'CatalogItemController.php';
include_once '../models/CatalogItem.php';

class CatalogItemListController extends CatalogItemController {

    public function __construct() {
        parent::__construct();
    }

    public function getList() {
        $query = 'SELECT c.name as category_name,
                    i.id,
                    i.category_id,
                    i.title,
                    i.body
                FROM 
                    '.$this->table.' i 
                LEFT JOIN 
                    categories c ON i.category_id = c.id 
                ORDER BY 
                    i.id DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            /** return Array of Objects CatalogItem */
            return $this->fetchCatalogItemRow($stmt);
        } 
            
        return null;
    }

    private function fetchCatalogItemRow($result) {
        $items_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $catalogItem = new CatalogItem();
            $catalogItem->id = $row['id'];
            $catalogItem->category_id = $row['category_id'];
            $catalogItem->category_name = $row['category_name'];
            $catalogItem->title = $row['title'];
            $catalogItem->body = $row['body'];

            array_push($items_arr, $catalogItem);
        }

        return $items_arr;
    }

}