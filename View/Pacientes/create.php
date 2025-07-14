<?php
include_once "../../Controller/PacienteController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pacienteModel->insertar($_POST["id"], $_POST["nombre"], $_POST["email"], $_POST["telefono"], $_POST["direccion"]);
    header("Location: list.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
    <h2>Nuevo Paciente</h2>
    <form method="post">
        <div class="mb-3">
            <label>ID</label>
            <input type="number" name="id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>
        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</main>
<?php PrintFooter(); ?>
</body>
</html>
