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

$error=''; $items=[];
try { $items = rows_from($pagoModel->listar()); }
catch(Throwable $t){ $error=$t->getMessage(); }
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Pagos</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<a class="btn btn-primary mb-3" href="create.php">Nuevo Pago</a>
<table class="table table-bordered table-sm">
<thead><tr><th>ID</th><th>Paciente</th><th>Fecha</th><th>Monto</th><th>Método</th><th>Acciones</th></tr></thead>
<tbody>
<?php foreach($items as $r): ?>
<tr>
  <td><?=htmlspecialchars($r['ID_PAGO'])?></td>
  <td><?=htmlspecialchars($r['PACIENTE']??'')?></td>
  <td><?=htmlspecialchars($r['FECHA_PAGO']??$r['FECHA']??'')?></td>
  <td><?=htmlspecialchars($r['MONTO']??'')?></td>
  <td><?=htmlspecialchars($r['METODO']??$r['METODO_PAGO']??'')?></td>
  <td>
    <a class="btn btn-sm btn-warning" href="edit.php?id=<?=urlencode($r['ID_PAGO'])?>">Editar</a>
    <a class="btn btn-sm btn-danger" href="edit.php?id=<?=urlencode($r['ID_PAGO'])?>&delete=1" onclick="return confirm('¿Eliminar?')">Eliminar</a>
  </td>
</tr>
<?php endforeach; if(!$items):?><tr><td colspan="7" class="text-center">Sin registros</td></tr><?php endif;?>
</tbody></table></main></body></html>

<?php PrintFooter(); ?>