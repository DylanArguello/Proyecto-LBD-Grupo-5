<?php
include_once "../../Controller/EspecialidadController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

$id = $_GET["id"];
$datos = $especialidadModel->obtenerPorId($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $especialidadModel->actualizar($_POST["id"], $_POST["nombre"]);
    header("Location: list.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
    <h2>Editar Especialidad</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $datos['ID_ESPECIALIDAD'] ?>">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $datos['NOMBRE'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</main>
<?php PrintFooter(); ?>
</body>
</html>
