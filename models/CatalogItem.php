<?php

namespace pcb\models;

require_once '../interfaces/ModelInterface.php';

use pcb\interfaces\ModelInterface;

class CatalogItem implements ModelInterface {

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
            case 'id':
                $this->id = $propValue;
                break;
            case 'category_id':
                $this->category_id = $propValue;
                break;
            case 'category_name':
                $this->category_name = $propValue;
                break;
            case 'title':
                $this->title = $propValue;
                break;
            case 'body':
                $this->body = $propValue;
                break;
        }
    }
}