<?php
// View/Recordatorio/edit.php
include_once __DIR__ . "/../../Controller/RecordatorioController.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: list.php"); exit; }

$error = '';
try { $item = $recordatorioModel->obtener($id); } catch (Throwable $t) { $error = $t->getMessage(); $item = null; }

if (isset($_GET['cancel'])) {
  try {
    $recordatorioModel->cancelar($id);
    $_SESSION['flash_success'] = 'Recordatorio cancelado correctamente.';
    header("Location: list.php"); exit;
  } catch (Throwable $t) { $error = $t->getMessage(); }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $recordatorioModel->reprogramar($id, $_POST['FECHA_ENVIO'] ?? '');
    $_SESSION['flash_success'] = 'Recordatorio reprogramado correctamente.';
    header("Location: list.php"); exit;
  } catch (Throwable $t) { $error = $t->getMessage(); }
}

include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?>
<body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Reprogramar Recordatorio</h2>

<?php if(!empty($_SESSION['flash_success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?=htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']);?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>

<?php if(!$item): ?>
  <div class="alert alert-warning">No se encontró el recordatorio solicitado.</div>
  <a class="btn btn-secondary" href="list.php">Volver</a>
<?php else: ?>
  <div class="mb-2"><strong>ID Cita:</strong> <?=htmlspecialchars($item['ID_CITA']??'')?></div>
  <div class="mb-2"><strong>Mensaje:</strong> <?=htmlspecialchars($item['MENSAJE']??'')?></div>
  <form method="post" autocomplete="off">
    <label class="form-label">Nueva fecha de envío</label>
    <input class="form-control mb-3" type="date" name="FECHA_ENVIO"
           value="<?=htmlspecialchars($item['FECHA_ENVIO']??'')?>" required>
    <button class="btn btn-success">Reprogramar</button>
    <a class="btn btn-secondary" href="list.php">Cancelar</a>
  </form>
<?php endif; ?>
</main>
</body></html>
