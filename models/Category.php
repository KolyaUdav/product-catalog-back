<?php

namespace pcb\models;

require_once '../interfaces/ModelInterface.php';

use pcb\interfaces\ModelInterface;

class Category implements ModelInterface {

    private const ID = 'id';
    private const NAME = 'name';

    public int $id;
    public string $name;

    public function addValueToProperties($propName, $propValue) {
        switch ($propName) {
            case self::ID:
                $this->id = $propValue;
                break;
            case self::NAME:
                $this->name = $propValue;
                break;
        }
    }

}