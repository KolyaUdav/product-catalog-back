<?php

namespace pcb\api;

include_once '../controllers/Controller.php';

class Api {

    protected function putDataToArray($data): array {
        return get_object_vars($data);
    }

    protected function prepareDataToSendClient($dataArr): string {
        return json_encode($dataArr);
    }

    protected function jsonToAssocArray($jsonString): array {
        return json_decode($jsonString, true); // return assoc arr
    }

}