<?php include_once "../../Controller/UsuarioController.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html><html lang="es">
<?php PrintCss(); ?>
<body><?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Usuarios</h2>
  <a href="create.php" class="btn btn-success mb-3">Nuevo Usuario</a>

  <table class="table table-bordered">
    <thead>
      <tr><th>ID</th><th>Usuario</th><th>Tipo</th><th>Acciones</th></tr>
    </thead>
    <tbody>
    <?php $st = $usuarioModel->obtenerTodos();
          while ($u = oci_fetch_assoc($st)): ?>
      <tr>
        <td><?= $u['ID_USUARIO'] ?></td>
        <td><?= $u['NOMBRE_USUARIO'] ?></td>
        <td><?= $u['TIPO_USUARIO'] ?></td>
        <td>
          <a href="edit.php?id=<?= $u['ID_USUARIO'] ?>" class="btn btn-sm btn-warning">Editar</a>
          <a href="delete.php?id=<?= $u['ID_USUARIO'] ?>" class="btn btn-sm btn-danger"
             onclick="return confirm('¿Eliminar usuario?')">Eliminar</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</main>
<?php PrintFooter(); ?>
</body></html>
