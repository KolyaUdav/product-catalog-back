<?php

namespace pcb\api\item;

include_once('../config/Database.php');

use pcb\config\Database as Database;

class ApiCatalogItem {

    protected $db;

    protected function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    protected function putDataToArray($catalogItem): array
    {
        return array(
            'id' => $catalogItem->id,
            'title' => $catalogItem->title,
            'body' => html_entity_decode($catalogItem->body),
            'category_id' => $catalogItem->category_id,
            'category_name' => $catalogItem->category_name
        );
    }

    protected function prepareDataToSendClient($dataArr): string {
        return json_encode($dataArr);
    }

    protected function jsonToAssocArray($jsonString): array {
        return json_decode($jsonString, true); // return assoc arr
    }

}