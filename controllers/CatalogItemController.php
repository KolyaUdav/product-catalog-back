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
            $catalogItem->category_name = $row['category_name'];

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

        $stmt = parent::getConnection()->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $dataArr = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->dataToObject($dataArr);
    }

    /** Принимает на вход ассоциативный массив с данными о новом CatalogItem
     * возвращает True, если INSERT в БД прошёл успешно,
     * возвращает False, если есть ошибка
     */
    public function create(Array $dataArr): bool {
        $newCatalogItem = $this->dataToObject($dataArr);

        $query = 'INSERT INTO '.self::TABLE.' SET title = :title, body = :body, category_id = :category_id';

        $params = array();
        $params['names'] = array(':title', ':body', ':category_id');
        $params['values'] = array(
            $newCatalogItem->title,
            $newCatalogItem->body,
            $newCatalogItem->category_id
        );

        return parent::sendDataToDB($query, $newCatalogItem, $params);
    }

    public function update(Array $dataArr): bool {
        $updCatalogItem = $this->dataToObject($dataArr);

        $query = 'UPDATE '.self::TABLE.' SET title = :title, body = :body, category_id = :category_id WHERE id = :id';

        $params = array();
        $params['names'] = array(':id', ':title', ':body', ':category_id');
        $params['values'] = array(
            $updCatalogItem->id,
            $updCatalogItem->title,
            $updCatalogItem->body,
            $updCatalogItem->category_id
        );

        return parent::sendDataToDB($query, $updCatalogItem, $params);
    }

    public function delete(Array $dataArr): bool {
        $deleteCatalogItem = $this->dataToObject($dataArr);

        $query = 'DELETE FROM '.self::TABLE.' WHERE id = :id';

        $params = array();
        $params['names'] = array(':id');
        $params['values'] = array(
            $deleteCatalogItem->id
        );

        return parent::sendDataToDB($query, $deleteCatalogItem, $params);
    }

    private function dataToObject(Array $dataArr): ModelInterface {
        $cleanedDataArr = parent::cleanData($dataArr);

        return $this->createCatalogItemObject($cleanedDataArr);
    }

    private function createCatalogItemObject(Array $dataArr): ModelInterface {
        $catalogItem = new CatalogItem();

        $properties = array_keys(parent::getPublicProperties($catalogItem)); // Получаем все public properties

        foreach ($properties as $prop) {
            if (array_key_exists($prop, $dataArr)) {
                /** Используем метод для автоматического присваивания value необходимым свойствам */
                $catalogItem->addValueToProperties($prop, $dataArr[$prop]);
            }
        }

        return $catalogItem;
    }
}