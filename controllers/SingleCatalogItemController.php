<?php

include_once 'CatalogItemController.php';
include_once '../models/CatalogItem.php';

class SingleCatalogItemController extends CatalogItemController {

    public function __construct() {
        parent::__construct();
    }

    public function getSingleItem($id) {
        $query = 'SELECT c.name as category_name, 
                    i.id, 
                    i.category_id, 
                    i.title, 
                    i.body 
                FROM 
                    '.$this->table.' i 
                LEFT JOIN 
                    categories c ON i.category_id = c.id 
                WHERE i.id = :id LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $row = $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $catalogItem = new CatalogItem();
        $catalogItem->id = $row['id'];
        $catalogItem->category_id = $row['category_id'];
        $catalogItem->category_name = $row['category_name'];
        $catalogItem->title = $row['title'];
        $catalogItem->body = $row['body'];
        return $catalogItem;
    }

    /** Принимает на вход ассоциативный массив с данными о новом CatalogItem
     * возвращает True, если INSERT в БД прошёл успешно,
     * возвращает False, если есть ошибка
     */
    public function createSingleItem($dataArr) {
        $cleanedDataArr = $this->cleanData($dataArr);

        $newCatalogItem = $this->createSingleCatalogItemObj($cleanedDataArr);

        $query = 'INSERT INTO '.$this->table.' SET title = :title, body = :body, category_id = :category_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $newCatalogItem->title);
        $stmt->bindParam(':body', $newCatalogItem->body);
        $stmt->bindParam(':category_id', $newCatalogItem->category_id);

        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s.\n', $stmt->error);
        
        return false;
    }

    private function cleanData($dataArr) {
        $cleanedDataArr = Array(
            'title' => htmlspecialchars(strip_tags($dataArr['title'])),
            'body' => htmlspecialchars(strip_tags($dataArr['body'])),
            'category_id' => htmlspecialchars(strip_tags($dataArr['category_id']))
        );

        return $cleanedDataArr;
    }

    private function createSingleCatalogItemObj($cleanedDataArr) {
        $newCatalogItem = new CatalogItem();
        $newCatalogItem->title = $cleanedDataArr['title'];
        $newCatalogItem->body = $cleanedDataArr['body'];
        $newCatalogItem->category_id = $cleanedDataArr['category_id'];

        return $newCatalogItem;
    }

}