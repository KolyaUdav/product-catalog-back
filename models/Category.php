<?php

namespace pcb\models;

require_once '../interfaces/ModelInterface.php';

use pcb\interfaces\ModelInterface;

class Category implements ModelInterface {

    public int $id;
    public string $name;

    public function addValueToProperties($propName, $propValue) {
        switch ($propName) {
            case 'id':
                $this->id = $propValue;
                break;
            case 'name':
                $this->name = $propValue;
                break;
        }
    }

}