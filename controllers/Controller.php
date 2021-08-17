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

    protected function getConnection(): PDO {
        return $this->conn;
    }

    protected function queryDB(string $query, callable $bindFunction): PDOStatement {
        $stmt = $this->getConnection()->prepare($query);
        call_user_func($bindFunction, $stmt);
        $stmt->execute();

        return $stmt;
    }

    protected function getListFromDB(string $query, callable $bindFunction, callable $putObjectFunction): array {
        $result = $this->queryDB($query, $bindFunction);
        return $this->fetchRow($result, $putObjectFunction);
    }

    protected function cleanData(Array $dataArr): array {
        $cleanedDataArr = Array();

        foreach ($dataArr as $data) {
            $clean_data = htmlspecialchars(strip_tags($data));
            $key = array_search($data, $dataArr);
            $cleanedDataArr[$key] = $clean_data;
        }

        return $cleanedDataArr;
    }

    protected function fetchRow($result, callable $putObject): array {
        $arr = array();

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $object = call_user_func($putObject, $row);

                array_push($arr, $object);
            }

            return $arr;
        }

        $arr['message'] = 'No list.';

        return $arr;
    }

    /**
     * @throws Exception
     */
    protected function valueNotEmpty($value) {
        if (empty($value)) {
            throw new Exception('Some variables are empty.');
        }

        return $value;
    }

    /**
     * $params - ассоциативный двумерный массив формата $params['names'] и $params['values']
    */
    protected function sendDataToDB(string $query, ModelInterface $object, array $params): bool {
        try {
            $this->queryDB($query, function(PDOStatement $stmt) use($object, $params) {
                for ($i = 0; $i < count($params['names']); $i++) {
                    $stmt->bindValue($params['names'][$i], $this->valueNotEmpty($params['values'][$i]));
                }
            });
        } catch (Exception $e) {
            printf('Error: %s', $e->getMessage());
            return false;
        }

        return true;
    }

    protected function getPublicProperties(ModelInterface $object): array {
        return get_class_vars($object::class);
    }

}