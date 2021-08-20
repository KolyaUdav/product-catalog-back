<?php

namespace pcb\api;

require_once '../controllers/Controller.php';

class Api {

    protected function putDataToArray($data): array {
        return get_object_vars($data);
    }

    protected function prepareDataToSendClient(array $dataArr): string {
        return json_encode($dataArr);
    }

    protected function jsonToAssocArray(string $jsonString): array {
        return json_decode($jsonString, true); // return assoc arr
    }

    protected function toWrapObjList(array $list): array {
        $obj_arr = Array();
        $obj_arr['data'] = Array();

        foreach ($list as $obj) {
            /** Данные объекта пакуем в ассоц. массив, затем добавляем его в массив obj_arr[data] */
            array_push($obj_arr['data'], $this->putDataToArray($obj));
        }

        return $obj_arr;
    }

}