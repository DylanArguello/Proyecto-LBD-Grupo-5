<?php
include_once __DIR__ . "/../../Controller/RecordatorioController.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$vm = recordatorio_handle_edit($_GET, $_POST);
$item = $vm['item']; $error = $vm['error'];
$fecha_val = $vm['fecha_val'];
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
    <input class="form-control mb-3" type="date" name="FECHA_ENVIO" value="<?=htmlspecialchars($fecha_val)?>" required>
    <button class="btn btn-success">Confirmar</button>
    <a class="btn btn-secondary" href="list.php">Cancelar</a>
  </form>
<?php endif; ?>
</main>
</body></html>

<?php PrintFooter(); ?>