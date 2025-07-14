<?php include_once "../../Controller/PagoController.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>

<!DOCTYPE html><html lang="es">
<?php PrintCss(); ?>
<body><?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Pagos</h2>
  <a href="create.php" class="btn btn-success mb-3">Nuevo Pago</a>

  <table class="table table-bordered">
    <thead>
      <tr><th>ID</th><th>Paciente</th><th>Monto</th><th>Fecha</th><th>Método</th><th>Acciones</th></tr>
    </thead>
    <tbody>
    <?php $st = $pagoModel->obtenerTodos();
          while ($p = oci_fetch_assoc($st)): ?>
      <tr>
        <td><?= $p['ID_PAGO'] ?></td>
        <td><?= $p['PACIENTE'] ?></td>
        <td><?= $p['MONTO'] ?></td>
        <td><?= $p['FECHA'] ?></td>
        <td><?= $p['METODO_PAGO'] ?></td>
        <td>
          <a href="edit.php?id=<?= $p['ID_PAGO'] ?>" class="btn btn-sm btn-warning">Editar</a>
          <a href="delete.php?id=<?= $p['ID_PAGO'] ?>" class="btn btn-sm btn-danger"
             onclick="return confirm('¿Eliminar pago?')">Eliminar</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</main>
<?php PrintFooter(); ?>
</body></html>
