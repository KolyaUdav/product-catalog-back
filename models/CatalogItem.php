<?php

namespace pcb\models;

class CatalogItem {

    /** ПРИ ОБЪЯВЛЕНИИ НОВОГО PUBLIC-СВОЙСТВА
     * НЕОБХОДИМО ДОБАВИТЬ ЕГО ИМЯ В SWITCH-КОНСТРУКЦИЮ 
     * МЕТОДА addValueToProperty
     */
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;

    /** Для автоматического добавления значений свойствам */
    public function addValueToProperty($propName, $propValue) {
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