<?php
require_once __DIR__ . '/../Model/recordatorioModel.php';

class RecordatorioController {
    private $model;

    public function __construct() {
        $this->model = new RecordatorioModel();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function show($id) {
        return $this->model->getById($id);
    }

    public function store($data) {
        return $this->model->create($data);
    }

    public function update($data) {
        return $this->model->update($data);
    }

    public function destroy($id) {
        return $this->model->delete($id);
    }
}
?>
