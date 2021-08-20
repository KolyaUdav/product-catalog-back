<?php

namespace pcb\models;

require_once '../interfaces/ModelInterface.php';

use pcb\interfaces\ModelInterface;

class CatalogItem implements ModelInterface {

    private const ID = 'id';
    private const CATEGORY_ID = 'category_id';
    private const CATEGORY_NAME = 'category_name';
    private const TITLE = 'title';
    private const BODY = 'body';

    /** ПРИ ОБЪЯВЛЕНИИ НОВОГО PUBLIC-СВОЙСТВА
     * НЕОБХОДИМО ДОБАВИТЬ ЕГО ИМЯ В SWITCH-КОНСТРУКЦИЮ 
     * МЕТОДА addValueToProperty
     */
    public int $id;
    public int $category_id;
    public string $category_name;
    public string $title;
    public string $body;

    /** Для автоматического добавления значений свойствам */
    public function addValueToProperties($propName, $propValue) {
        switch ($propName) {
            case self::ID:
                $this->id = $propValue;
                break;
            case self::CATEGORY_ID:
                $this->category_id = $propValue;
                break;
            case self::CATEGORY_NAME:
                $this->category_name = $propValue;
                break;
            case self::TITLE:
                $this->title = $propValue;
                break;
            case self::BODY:
                $this->body = $propValue;
                break;
        }
    }
}