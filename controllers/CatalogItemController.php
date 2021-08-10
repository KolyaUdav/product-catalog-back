<?php

include_once '../config/Database.php';

class CatalogItemController {

    protected $conn;

    const TABLE = 'items';

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

    protected function cleanData($dataArr) {
        $cleanedDataArr = Array();

        foreach ($dataArr as $data) {
            $clean_data = htmlspecialchars(strip_tags($data));
            $key = array_search($data, $dataArr);
            $cleanedDataArr[$key] = $clean_data;
        }

        return $cleanedDataArr;
    }

}