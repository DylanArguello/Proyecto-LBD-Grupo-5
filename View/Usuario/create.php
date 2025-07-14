<?php include_once "../../Controller/UsuarioController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $usuarioModel->crear([
        'id'     => $_POST['id'],
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
  <h2>Registrar Usuario</h2>
  <form method="post">
    <input class="form-control mb-2" type="number" name="id"     placeholder="ID Usuario" required>
    <input class="form-control mb-2" type="text"   name="nombre" placeholder="Nombre de Usuario" required>
    <input class="form-control mb-2" type="password" name="clave"  placeholder="Contraseña" required>
    <select class="form-control mb-3" name="tipo" required>
      <option value="">Seleccione Tipo</option>
      <option value="ADMIN">Admin</option>
      <option value="PACIENTE">Paciente</option>
      <option value="DOCTOR">Doctor</option>
    </select>
    <button class="btn btn-success">Guardar</button>
    <a href="list.php" class="btn btn-secondary">Cancelar</a>
  </form>
</main>
<?php PrintFooter(); ?>
</body></html>
