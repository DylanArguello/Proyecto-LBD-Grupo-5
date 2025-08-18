<?php
include_once __DIR__ . "/../../Controller/DisponibilidadController.php";
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

$error=''; $doctores=[];
try { $doctores = rows_from($doctorModel->listar()); }
catch(Throwable $t){ $error=$t->getMessage(); }

if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $disponibilidadModel->crear([
      'ID_DOCTOR'   => $_POST['ID_DOCTOR']   ?? '',
      'DIA_SEMANA'  => $_POST['DIA_SEMANA']  ?? '',
      'HORA_INICIO' => substr($_POST['HORA_INICIO'] ?? '',0,5), // 'HH:MM'
      'HORA_FIN'    => substr($_POST['HORA_FIN']    ?? '',0,5),
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){ $error=$t->getMessage(); }
}
$dias=['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO'];
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Nueva Disponibilidad</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post" autocomplete="off">
  <label class="form-label">Doctor</label>
  <select class="form-select mb-2" name="ID_DOCTOR" required>
    <option value="">-- Seleccione --</option>
    <?php foreach($doctores as $d): ?>
      <option value="<?=htmlspecialchars($d['ID_DOCTOR'])?>"><?=htmlspecialchars($d['NOMBRE'])?></option>
    <?php endforeach;?>
  </select>

  <label class="form-label">Día de la semana</label>
  <select class="form-select mb-2" name="DIA_SEMANA" required>
    <option value="">-- Seleccione --</option>
    <?php foreach($dias as $d): ?><option value="<?=$d?>"><?=$d?></option><?php endforeach;?>
  </select>

  <label class="form-label">Hora Inicio</label>
  <input class="form-control mb-2" type="time" name="HORA_INICIO" required>

  <label class="form-label">Hora Fin</label>
  <input class="form-control mb-3" type="time" name="HORA_FIN" required>

  <button class="btn btn-success">Guardar</button>
  <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form>
</main></body></html>

<?php PrintFooter(); ?>