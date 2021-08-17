<?php

namespace pcb\controllers;

require_once 'Controller.php';
require_once '../models/Category.php';
require_once '../interfaces/ControllerInterface.php';

use pcb\interfaces\ModelInterface;
use pcb\models\Category;
use pcb\interfaces\ControllerInterface;

class CategoryController extends Controller implements ControllerInterface {

    const TABLE = 'categories';

    public function __construct() {
        parent::__construct();
    }

    public function getList(): array {
        return array();
    }

    private function fetchCategoryRow($rowData): array {
        if ($rowData->rowCount() > 0) {
            parent::fetchRow($rowData, function($row) {
                $category = new Category();
                $category->id = $row['id'];
                $category->name = $row['name'];

                return $category;
            });
        }

        return array('message' => 'No category list.');

    }

    public function get($id): ModelInterface
    {
        return new Category();

    }

    public function create(array $dataArr): bool
    {
        return false;
    }

    public function update(array $dataArr): bool
    {
        return false;
    }

    public function delete(array $dataArr): bool
    {
        return false;
    }
}