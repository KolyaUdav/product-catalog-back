<?php

namespace pcb\controllers;

include_once 'CatalogItemController.php';

use PDO;

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
        
        return parent::dataToObject($dataArr);
    }

    /** Принимает на вход ассоциативный массив с данными о новом CatalogItem
     * возвращает True, если INSERT в БД прошёл успешно,
     * возвращает False, если есть ошибка
     */
    public function createSingleItem(Array $dataArr): bool {
        $newCatalogItem = parent::dataToObject($dataArr);

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

    public function updateSingleItem(Array $dataArr): bool {
        $updCatalogItem = parent::dataToObject($dataArr);

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

    public function deleteSingleItem(Array $dataArr): bool {
        $deleteCatalogItem = parent::dataToObject($dataArr);

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