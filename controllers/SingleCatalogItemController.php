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
                    '.parent::TABLE.' i 
                LEFT JOIN 
                    categories c ON i.category_id = c.id 
                WHERE i.id = :id LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $dataArr = $stmt->fetch(PDO::FETCH_ASSOC);

        $catalogItem = parent::createCatalogItemObject($dataArr);
        
        return $catalogItem;
    }

    /** Принимает на вход ассоциативный массив с данными о новом CatalogItem
     * возвращает True, если INSERT в БД прошёл успешно,
     * возвращает False, если есть ошибка
     */
    public function createSingleItem($dataArr) {
        $cleanedDataArr = parent::cleanData($dataArr);

        $newCatalogItem = parent::createCatalogItemObject($dataArr);

        $query = 'INSERT INTO '.parent::TABLE.' SET title = :title, body = :body, category_id = :category_id';

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

    public function updateSingleItem($dataArr) {
        $cleanedDataArr = parent::cleanData($dataArr);

        $updCatalogItem = parent::createCatalogItemObject($dataArr);

        $query = 'UPDATE '.parent::TABLE.' SET title = :title, body = :body, category_id = :category_id WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $updCatalogItem->id);
        $stmt->bindParam(':title', $updCatalogItem->title);
        $stmt->bindParam(':body', $updCatalogItem->body);
        $stmt->bindParam(':category_id', $updCatalogItem->category_id);

        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s.\n', $stmt->error);

        return false;
    }

    public function deleteSingleItem($dataArr) {
        $cleanedDataArr = parent::cleanData($dataArr); // clean ID

        $deleteCatalogItem = parent::createCatalogItemObject($dataArr);

        $query = 'DELETE FROM '.parent::TABLE.' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $deleteCatalogItem->id);
        
        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s.\n', $stmt->error);

        return false;
    }

}