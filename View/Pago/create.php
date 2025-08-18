<?php
include_once __DIR__ . "/../../Controller/PagoController.php";
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

$error=''; $citas=[];
try {
  $citas = rows_from($citaModel->listar()); // PKG_CITA.sp_listar(cur)
} catch (Throwable $t) { $error=$t->getMessage(); }

if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $pagoModel->crear([
      'ID_CITA'    => $_POST['ID_CITA']    ?? '',
      'MONTO'      => $_POST['MONTO']      ?? '',
      'FECHA_PAGO' => $_POST['FECHA_PAGO'] ?? '',
      'METODO'     => $_POST['METODO']     ?? '',
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){ $error=$t->getMessage(); }
}
$metodos=['EFECTIVO','TARJETA','TRANSFERENCIA'];
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Nuevo Pago</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post" autocomplete="off">
  <label class="form-label">Cita</label>
  <select class="form-select mb-2" name="ID_CITA" required>
    <option value="">-- Seleccione --</option>
    <?php foreach($citas as $c):
      $pac = $c['PACIENTE'] ?? ''; // si PKG_CITA no trae nombre, quedará vacío
      $lbl = trim(($pac ?: ('Cita #'.$c['ID_CITA'])) . ' - ' . ($c['FECHA'] ?? '') . ' ' . substr($c['HORA'] ?? '',0,5));
    ?>
      <option value="<?=htmlspecialchars($c['ID_CITA'])?>"><?=htmlspecialchars($lbl)?></option>
    <?php endforeach;?>
  </select>

  <label class="form-label">Monto</label>
  <input class="form-control mb-2" name="MONTO" type="number" step="0.01" min="0" required>

  <label class="form-label">Fecha de pago</label>
  <input class="form-control mb-2" name="FECHA_PAGO" type="date" required>

  <label class="form-label">Método</label>
  <select class="form-select mb-3" name="METODO" required>
    <?php foreach($metodos as $m): ?><option value="<?=$m?>"><?=$m?></option><?php endforeach;?>
  </select>

  <button class="btn btn-success">Guardar</button>
  <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>
