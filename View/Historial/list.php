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

$error=''; $items=[];
try { $items = rows_from($historialModel->listar()); }
catch(Throwable $t){ $error=$t->getMessage(); }
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Historiales Médicos</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<a class="btn btn-primary mb-3" href="create.php">Nuevo Historial</a>
<table class="table table-bordered table-sm">
<thead>
  <tr><th>ID</th><th>Paciente</th><th>Cita</th><th>Diagnóstico</th><th>Tratamiento</th><th>Acciones</th></tr>
</thead>
<tbody>
<?php if ($items): foreach($items as $r): ?>
<tr>
  <td><?=htmlspecialchars($r['ID_HISTORIAL'])?></td>
  <td><?=htmlspecialchars($r['ID_PACIENTE'] ?? '')?></td>
  <td><?=htmlspecialchars($r['ID_CITA'] ?? '')?></td>
  <td><?=htmlspecialchars($r['DIAGNOSTICO'] ?? '')?></td>
  <td><?=htmlspecialchars($r['TRATAMIENTO'] ?? '')?></td>
  <td>
    <a class="btn btn-sm btn-warning" href="edit.php?id=<?=urlencode($r['ID_HISTORIAL'])?>">Editar</a>
    <a class="btn btn-sm btn-danger" href="edit.php?id=<?=urlencode($r['ID_HISTORIAL'])?>&delete=1" onclick="return confirm('¿Eliminar?')">Eliminar</a>
  </td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="6" class="text-center">Sin registros</td></tr>
<?php endif; ?>
</tbody></table>
</main></body></html>

<?php PrintFooter(); ?>