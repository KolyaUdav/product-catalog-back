<?php

namespace pcb\controllers;

require_once 'Controller.php';
require_once '../models/Category.php';
require_once '../interfaces/ControllerInterface.php';

use pcb\interfaces\ModelInterface;
use pcb\models\Category;
use pcb\interfaces\ControllerInterface;
use PDO;

class CategoryController extends Controller implements ControllerInterface {

    const TABLE = 'categories';

    public function __construct() {
        parent::__construct();
    }

    public function getList(): array {
        $query = 'SELECT * FROM '.self::TABLE;

        return parent::getListFromDB($query, function ($stmt) {}, function ($row) {
            $category = new Category();
            $category->id = $row['id'];
            $category->name = $row['name'];

            return $category;
        });
    }

    public function get($id): ModelInterface {
        $query = 'SELECT * FROM '.self::TABLE.' WHERE id = :id';

        $stmt = parent::queryDB($query, function ($stmt) use($id) {
            $stmt->bindValue(':id', $id);
        });

        $dataArr = $stmt->fetch(PDO::FETCH_ASSOC);

        return parent::dataToObject($dataArr, new Category());
    }

    public function create(array $dataArr): bool
    {
        $category = parent::dataToObject($dataArr, new Category());
        $query = 'INSERT INTO '.self::TABLE.' SET name = :name';

        return parent::sendDataToDB($query, array(':name' => $category->name));
    }

    public function update(array $dataArr): bool
    {
        $category = parent::dataToObject($dataArr, new Category());
        $query = 'UPDATE '.self::TABLE.' SET name = :name WHERE id = :id';

        return parent::sendDataToDB($query, array(':name' => $category->name, ':id' => $category->id));
    }

    public function delete(array $dataArr): bool
    {
        $category = parent::dataToObject($dataArr, new Category());
        $query = 'DELETE FROM '.self::TABLE.' WHERE id = :id';

        return parent::sendDataToDB($query, array(':id' => $category->id));
    }
}