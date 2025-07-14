<?php
include_once "../../Controller/EspecialidadController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $especialidadModel->insertar($_POST["id"], $_POST["nombre"]);
    header("Location: list.php");
}
?>
<!DOCTYPE html>

<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
    <h2>Nueva Especialidad</h2>
    <form method="post">
        <div class="mb-3">
            <label>ID Especialidad</label>
            <input type="number" name="id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</main>
<?php PrintFooter(); ?>
</body>
</html>
