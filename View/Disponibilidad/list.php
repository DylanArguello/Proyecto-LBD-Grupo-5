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

$error=''; $rows=[];
try { $rows = rows_from($disponibilidadModel->listar()); }
catch(Throwable $t){ $error=$t->getMessage(); }

?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Disponibilidades de Doctores</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<a class="btn btn-primary mb-3" href="create.php">Nueva Disponibilidad</a>
<table class="table table-bordered table-sm">
<thead><tr><th>ID</th><th>Doctor</th><th>Día</th><th>Hora Inicio</th><th>Hora Fin</th><th>Acciones</th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?>
<tr>
  <td><?=htmlspecialchars($r['ID_DISPONIBILIDAD'])?></td>
  <td><?=htmlspecialchars($r['DOCTOR'] ?? $r['ID_DOCTOR'] ?? '')?></td>
  <td><?=htmlspecialchars($r['DIA_SEMANA'] ?? '')?></td>
  <td><?=htmlspecialchars($r['HORA_INICIO'] ?? '')?></td>
  <td><?=htmlspecialchars($r['HORA_FIN'] ?? '')?></td>
  <td>
    <a class="btn btn-sm btn-warning" href="edit.php?id=<?=urlencode($r['ID_DISPONIBILIDAD'])?>">Editar</a>
    <a class="btn btn-sm btn-danger" href="edit.php?id=<?=urlencode($r['ID_DISPONIBILIDAD'])?>&delete=1" onclick="return confirm('¿Eliminar?')">Eliminar</a>
  </td>
</tr>
<?php endforeach; if(!$rows):?><tr><td colspan="6" class="text-center">Sin registros</td></tr><?php endif;?>
</tbody></table></main></body></html>

<?php PrintFooter(); ?>