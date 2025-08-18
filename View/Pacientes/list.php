<?php
include_once __DIR__ . "/../../Controller/PacienteController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

$error = '';
try { $items = $pacienteModel->listar(); } catch (Throwable $t) { $error=$t->getMessage(); $items=[]; }
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Pacientes</h2>
  <?php if ($error): ?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif; ?>
  <a class="btn btn-primary mb-3" href="create.php">Nuevo Paciente</a>
  <table class="table table-bordered table-sm">
    <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach($items as $r): ?>
      <tr>
        <td><?=htmlspecialchars($r['ID_PACIENTE'])?></td>
        <td><?=htmlspecialchars($r['NOMBRE']??'')?></td>
        <td><?=htmlspecialchars($r['EMAIL']??'')?></td>
        <td><?=htmlspecialchars($r['TELEFONO']??'')?></td>
        <td><?=htmlspecialchars($r['DIRECCION']??'')?></td>
        <td>
          <a class="btn btn-sm btn-warning" href="edit.php?id=<?=urlencode($r['ID_PACIENTE'])?>">Editar</a>
          <a class="btn btn-sm btn-danger" href="edit.php?id=<?=urlencode($r['ID_PACIENTE'])?>&delete=1" onclick="return confirm('¿Eliminar?')">Eliminar</a>
        </td>
      </tr>
    <?php endforeach; if(!$items): ?><tr><td colspan="6" class="text-center">Sin registros</td></tr><?php endif; ?>
    </tbody>
  </table>
</main></body></html>
