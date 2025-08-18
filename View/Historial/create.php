<?php
include_once __DIR__ . "/../../Controller/HistorialController.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

function rows_from($maybe) {
  $out = [];
  if (is_object($maybe) && get_class($maybe) === 'OCIStatement') {
    while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
  } elseif (is_resource($maybe)) {
    while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
  } elseif (is_array($maybe)) { $out = $maybe; }
  return $out;
}

$error='';
try {
  $pacientes = rows_from($pacienteModel->listar());
  $citas     = rows_from($citaModel->listar());
} catch(Throwable $t){
  $error=$t->getMessage(); $pacientes=$citas=[];
}

if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $historialModel->crear([
      'ID_PACIENTE' => $_POST['ID_PACIENTE'] ?? '',
      'ID_CITA'     => $_POST['ID_CITA']     ?? '',
      'DIAGNOSTICO' => $_POST['DIAGNOSTICO'] ?? '',
      'TRATAMIENTO' => $_POST['TRATAMIENTO'] ?? '',
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){ $error=$t->getMessage(); }
}
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Nuevo Historial Médico</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post" autocomplete="off">
  <label class="form-label">Paciente</label>
  <select class="form-select mb-2" name="ID_PACIENTE" required>
    <option value="">-- Seleccione --</option>
    <?php foreach($pacientes as $p): ?>
      <option value="<?=htmlspecialchars($p['ID_PACIENTE'])?>">
        <?=htmlspecialchars($p['NOMBRE'] ?? $p['ID_PACIENTE'])?>
      </option>
    <?php endforeach;?>
  </select>

  <label class="form-label">Cita</label>
  <select class="form-select mb-2" name="ID_CITA" required>
    <option value="">-- Seleccione --</option>
    <?php foreach($citas as $c):
      $lbl = trim(($c['PACIENTE'] ?? '') . ' - ' . ($c['FECHA'] ?? '') . ' ' . substr($c['HORA'] ?? '',0,5));
    ?>
      <option value="<?=htmlspecialchars($c['ID_CITA'])?>"><?=htmlspecialchars($lbl)?></option>
    <?php endforeach;?>
  </select>

  <label class="form-label">Diagnóstico</label>
  <textarea class="form-control mb-2" name="DIAGNOSTICO" rows="3" required></textarea>

  <label class="form-label">Tratamiento</label>
  <textarea class="form-control mb-3" name="TRATAMIENTO" rows="3" required></textarea>

  <button class="btn btn-success">Guardar</button>
  <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form>
</main></body></html>
