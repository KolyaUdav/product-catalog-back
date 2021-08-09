<?php

include_once '../config/Database.php';

class CatalogItemController {

    protected $conn;
    protected $table = 'items';

    protected function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    protected function putRowDataToArray($id, $title, $body, $category_id, $category_name) {
        return array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'category_id' => $category_id,
            'category_name' => $category_name
        );
    }

}