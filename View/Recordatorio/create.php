<?php
// View/Recordatorio/create.php
include_once __DIR__ . "/../../Controller/RecordatorioController.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

if (session_status() === PHP_SESSION_NONE) session_start();
$error=''; 
try { $citas = $citaModel->listar(); } catch (Throwable $t) { $error = $t->getMessage(); $citas = []; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $recordatorioModel->crear([
      'ID_CITA'     => $_POST['ID_CITA']     ?? '',
      'MENSAJE'     => $_POST['MENSAJE']     ?? '',
      'FECHA_ENVIO' => $_POST['FECHA_ENVIO'] ?? '',
    ]);
    $_SESSION['flash_success'] = 'Recordatorio creado correctamente.';
    header("Location: list.php"); exit;
  } catch (Throwable $t) { $error = $t->getMessage(); }
}
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?>
<body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Nuevo Recordatorio</h2>

<?php if(!empty($_SESSION['flash_success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?=htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']);?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>

<form method="post" autocomplete="off">
  <label class="form-label">Cita</label>
  <select class="form-select mb-2" name="ID_CITA" required>
    <option value="">-- Seleccione --</option>
    <?php foreach($citas as $c): 
      $lbl=(($c['PACIENTE']??'').' - '.($c['FECHA']??'').' '.substr($c['HORA']??'',0,5)); ?>
      <option value="<?=htmlspecialchars($c['ID_CITA'])?>"><?=htmlspecialchars(trim($lbl))?></option>
    <?php endforeach; ?>
  </select>

  <label class="form-label">Mensaje</label>
  <textarea class="form-control mb-2" name="MENSAJE" rows="3" required></textarea>

  <label class="form-label">Fecha de envío</label>
  <input class="form-control mb-3" type="date" name="FECHA_ENVIO" required>

  <button class="btn btn-success">Guardar</button>
  <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form>
</main>
</body></html>
