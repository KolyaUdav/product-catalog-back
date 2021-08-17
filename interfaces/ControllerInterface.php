<?php

namespace pcb\interfaces;

require_once 'ModelInterface.php';

interface ControllerInterface {

    public function getList(): array;

    public function get($id): ModelInterface;

    public function create(array $dataArr): bool;

    public function update(array $dataArr): bool;

    public function delete(array $dataArr): bool;

}