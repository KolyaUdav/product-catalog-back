<?php

namespace pcb\controllers;

require_once '../config/Database.php';

use pcb\config\Database;
use pcb\interfaces\ModelInterface;
use PDO;
use PDOStatement;
use Exception;

class Controller {

    private PDO $conn;

    protected function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    /*Получение PDO-объекта для взаимодействия с БД*/
    private function getConnection(): PDO {
        return $this->conn;
    }

    /**
     * @param string $query
     * @param callable $bindFunction
     * @return PDOStatement
     */
    /* Выполнение запроса к БД */
    protected function queryDB(string $query, callable $bindFunction): PDOStatement {
        $stmt = $this->getConnection()->prepare($query);
        call_user_func($bindFunction, $stmt);
        $stmt->execute();

        return $stmt;
    }

    /**
     * @param string $query
     * @param callable $bindFunction
     * @param callable $putPropsFunction
     * @return array
     */
    /* Получение списка объектов из БД */
    protected function getListFromDB(string $query, callable $bindFunction, callable $putPropsFunction): array {
        $result = $this->queryDB($query, $bindFunction);

        return $this->fetchRow($result, $putPropsFunction);
    }

    protected function getSingleFromDB(string $query, ModelInterface $object, callable $bindFunction): ModelInterface {
        $stmt = $this->queryDB($query, $bindFunction);

        $dataArr = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($dataArr)) {
            $dataArr = array();
        }

        return $this->dataToObject($dataArr, $object);
    }

    /* Очистка поступающих извне данных */
    private function cleanData(Array $dataArr): array {
        $cleanedDataArr = Array();

        foreach ($dataArr as $data) {
            $clean_data = htmlspecialchars(strip_tags($data));
            $key = array_search($data, $dataArr);
            $cleanedDataArr[$key] = $clean_data;
        }

        return $cleanedDataArr;
    }

    /* Формирование массива данных из БД */
    private function fetchRow($result, callable $putPropsFunction): array {
        $arr = array();

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                /*
                 * $row содержит информацию из БД и используется
                 *  в дочерних классах для передачи значений в свойства объектов */
                $object = call_user_func($putPropsFunction, $row);

                array_push($arr, $object);
            }
        }

        return $arr;
    }

    /**
     * @throws Exception
     */
    /* Проверка данных, поступающих извне от клиента на то,
     чтобы все необходимые переменные не были пустыми */
    private function valueNotEmpty($value) {
        if (empty($value)) {
            throw new Exception('Some variables are empty.');
        }

        return $value;
    }

    /**
     * $params - ассоциативный двумерный массив формата $params['names'] и $params['values']
    */
    /* Отправка данных в базу (CREATE, UPDATE, DELETE) */
    protected function sendDataToDB(string $query, array $params): bool {
        try {
            $this->queryDB($query, function(PDOStatement $stmt) use($params) {
                $this->bindValues($params, $stmt);
            });
        } catch (Exception $e) {
            printf('Error: %s', $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @throws Exception
     */
    private function bindValues(array $valuesArr, PDOStatement $stmt) {
        foreach ($valuesArr as $value) {
            $stmt->bindValue(array_search($value, $valuesArr), $this->valueNotEmpty($value));
        }
    }

    /* Получение всех паблик-свойств из модели */
    private function getPublicProperties(ModelInterface $object): array {
        return get_class_vars($object::class);
    }

    /* Принимает в кач-ве аргумента пустой объект ModelInterface
    и заполняет его свойства данными из $dataArr */
    protected function dataToObject(array $dataArr, ModelInterface $object): ModelInterface {
        $cleanedDataArr = $this->cleanData($dataArr);

        return $this->createObject($cleanedDataArr, $object);
    }

    /* Заполняет свойства объекта ModelInterface */
    private function createObject(Array $dataArr, ModelInterface $object): ModelInterface {
        $properties = array_keys($this->getPublicProperties($object)); // Получаем все public properties

        foreach ($properties as $prop) {
            if (array_key_exists($prop, $dataArr)) {
                /** Используем метод для автоматического присваивания value необходимым свойствам */
                $object->addValueToProperties($prop, $dataArr[$prop]);
            }
        }

        return $object;
    }

}