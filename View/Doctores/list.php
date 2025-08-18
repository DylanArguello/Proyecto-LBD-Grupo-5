<?php
include_once __DIR__ . "/../../Controller/DoctorController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
$error=''; try{$items=$doctorModel->listar();}catch(Throwable $t){$error=$t->getMessage();$items=[];}
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Doctores</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<a class="btn btn-primary mb-3" href="create.php">Nuevo Doctor</a>
<table class="table table-bordered table-sm">
<thead><tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Especialidad</th><th>Acciones</th></tr></thead>
<tbody>
<?php foreach($items as $r): ?>
<tr>
  <td><?=htmlspecialchars($r['ID_DOCTOR'])?></td>
  <td><?=htmlspecialchars($r['NOMBRE']??'')?></td>
  <td><?=htmlspecialchars($r['TELEFONO']??'')?></td>
  <td><?=htmlspecialchars($r['ESPECIALIDAD']??$r['ID_ESPECIALIDAD']??'')?></td>
  <td>
    <a class="btn btn-sm btn-warning" href="edit.php?id=<?=urlencode($r['ID_DOCTOR'])?>">Editar</a>
    <a class="btn btn-sm btn-danger" href="edit.php?id=<?=urlencode($r['ID_DOCTOR'])?>&delete=1" onclick="return confirm('¿Eliminar?')">Eliminar</a>
  </td>
</tr>
<?php endforeach; if(!$items): ?><tr><td colspan="5" class="text-center">Sin registros</td></tr><?php endif;?>
</tbody></table></main></body></html>
