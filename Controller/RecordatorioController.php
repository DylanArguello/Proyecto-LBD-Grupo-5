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

  /** Cancela (elimina) un recordatorio y setea flash en sesión */
  public function destroy($id): void {
    $this->recordatorioModel->cancelar((int)$id);
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['flash_success'] = 'Recordatorio cancelado correctamente.';
  }
}

function recordatorio_handle_edit(array $query, array $post): array {
  $vm = [
    'error'     => '',
    'item'      => null,
    'fecha_val' => '',
  ];

  $model = new RecordatorioModel();
  if (session_status() === PHP_SESSION_NONE) session_start();

  $id = isset($query['id']) ? (int)$query['id'] : 0;
  if ($id <= 0) { header("Location: list.php"); exit; }

  // Cancelar recordatorio (desde link ?cancel=1)
  if (isset($query['cancel'])) {
    try {
      $model->cancelar($id);
      $_SESSION['flash_success'] = 'Recordatorio cancelado correctamente.';
      header("Location: list.php"); exit;
    } catch (Throwable $t) {
      $vm['error'] = $t->getMessage();
    }
  }

  // Reprogramar (POST)
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
      $fecha = trim((string)($post['FECHA_ENVIO'] ?? ''));
      $model->reprogramar($id, $fecha);
      $_SESSION['flash_success'] = 'Recordatorio reprogramado correctamente.';
      header("Location: list.php"); exit;
    } catch (Throwable $t) {
      $vm['error'] = $t->getMessage();
    }
  }

  // Cargar datos para la vista
  try {
    $vm['item'] = $model->obtener($id);
    $vm['fecha_val'] = (string)($vm['item']['FECHA_ENVIO'] ?? '');
  } catch (Throwable $t) {
    $vm['error'] = $vm['error'] ?: $t->getMessage();
  }

  return $vm;
}

$recordatorioModel = new RecordatorioModel();
$citaModel         = new CitaModel();
