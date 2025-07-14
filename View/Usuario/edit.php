<?php include_once "../../Controller/UsuarioController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
$datos = $usuarioModel->obtenerPorId($_GET['id']);

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $usuarioModel->actualizar([
        'id'     => $datos['ID_USUARIO'],
        'nombre' => $_POST['nombre'],
        'clave'  => $_POST['clave'],
        'tipo'   => $_POST['tipo']
    ]);
    header("Location: list.php"); exit;
}
?>
<!DOCTYPE html><html lang="es">
<?php PrintCss(); ?>
<body><?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Editar Usuario</h2>
  <form method="post">
    <input class="form-control mb-2" type="text" name="nombre"
           value="<?= $datos['NOMBRE_USUARIO'] ?>" required>
    <input class="form-control mb-2" type="password" name="clave"
           value="<?= $datos['CONTRASENA'] ?>" required>
    <select class="form-control mb-3" name="tipo" required>
      <option value="ADMIN" <?= $datos['TIPO_USUARIO']=='ADMIN' ? 'selected' : '' ?>>Admin</option>
      <option value="PACIENTE" <?= $datos['TIPO_USUARIO']=='PACIENTE' ? 'selected' : '' ?>>Paciente</option>
      <option value="DOCTOR" <?= $datos['TIPO_USUARIO']=='DOCTOR' ? 'selected' : '' ?>>Doctor</option>
    </select>
    <button class="btn btn-primary">Actualizar</button>
    <a href="list.php" class="btn btn-secondary">Cancelar</a>
  </form>
</main>
<?php PrintFooter(); ?>
</body></html>
