<?php
// Controller/RecordatorioController.php
require_once __DIR__ . '/../Model/RecordatorioModel.php';
require_once __DIR__ . '/../Model/CitaModel.php';

class RecordatorioController {
  public RecordatorioModel $recordatorioModel;
  public CitaModel $citaModel;

  public function __construct() {
    $this->recordatorioModel = new RecordatorioModel();
    $this->citaModel = new CitaModel();
  }

  public function destroy($id): void {
    $this->recordatorioModel->cancelar($id);
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['flash_success'] = 'Recordatorio cancelado correctamente.';
  }
}

// Variables que usan tus vistas (patrón existente en el proyecto)
$recordatorioModel = new RecordatorioModel();
$citaModel         = new CitaModel();
