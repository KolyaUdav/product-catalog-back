<?php

namespace pcb\controllers;

require_once '../interfaces/ControllerInterface.php';
require_once '../models/CatalogItem.php';
require_once '../interfaces/ModelInterface.php';

use pcb\interfaces\ModelInterface;
use pcb\models\CatalogItem;
use pcb\interfaces\ControllerInterface;
use PDO;

class CatalogItemController extends Controller implements ControllerInterface {

    const TABLE = 'items';

    public function __construct() {
        parent::__construct();
    }

    public function getList(): array {
        $query = 'SELECT c.name as category_name,
                    i.id,
                    i.category_id,
                    i.title,
                    i.body
                FROM 
                    '.self::TABLE.' i 
                LEFT JOIN 
                    categories c ON i.category_id = c.id 
                ORDER BY 
                    i.id DESC';

        return parent::getListFromDB($query, function ($stmt){}, function ($row) {
            $catalogItem = new CatalogItem();
            $catalogItem->id = $row['id'];
            $catalogItem->category_id = $row['category_id'];
            $catalogItem->title = $row['title'];
            $catalogItem->body = $row['body'];
            $catalogItem->category_name = $row['category_name'] ?? 'No Category';

            return $catalogItem;
        });
    }

    public function get($id): ModelInterface {
        $query = 'SELECT c.name as category_name, 
                    i.id, 
                    i.category_id, 
                    i.title, 
                    i.body 
                FROM 
                    '.self::TABLE.' i 
                LEFT JOIN 
                    categories c ON i.category_id = c.id 
                WHERE i.id = :id LIMIT 0,1';

        $stmt = parent::queryDB($query, function ($stmt) use($id) {
            $stmt->bindValue(':id', $id);
        });

        $dataArr = $stmt->fetch(PDO::FETCH_ASSOC);

        return parent::dataToObject($dataArr, new CatalogItem());
    }

    /** Принимает на вход ассоциативный массив с данными о новом CatalogItem
     * возвращает True, если INSERT в БД прошёл успешно,
     * возвращает False, если есть ошибка
     */
    public function create(Array $dataArr): bool {
        $catalogItem = parent::dataToObject($dataArr, new CatalogItem());
        $query = 'INSERT INTO '.self::TABLE.' SET title = :title, body = :body, category_id = :category_id';

        return parent::sendDataToDB($query, array(
            ':title' => $catalogItem->title,
            ':body' => $catalogItem->body,
            ':category_id' => $catalogItem->category_id
            ));
    }

    public function update(Array $dataArr): bool {
        $catalogItem = parent::dataToObject($dataArr, new CatalogItem());
        $query = 'UPDATE '.self::TABLE.' SET title = :title, body = :body, category_id = :category_id WHERE id = :id';

        return parent::sendDataToDB($query, array(
            ':title' => $catalogItem->title,
            ':body' => $catalogItem->body,
            ':category_id' => $catalogItem->category_id,
            ':id' => $catalogItem->id
        ));
    }

    public function delete(Array $dataArr): bool {
        $catalogItem = parent::dataToObject($dataArr, new CatalogItem());
        $query = 'DELETE FROM '.self::TABLE.' WHERE id = :id';

        return parent::sendDataToDB($query, array(
            ':id' => $catalogItem->id
        ));
    }

}