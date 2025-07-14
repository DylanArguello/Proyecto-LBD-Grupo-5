<?php
include_once "../../Controller/DisponibilidadController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

$id = $_GET["id"];
$datos = $disponibilidadModel->obtenerPorId($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $disponibilidadModel->actualizar($_POST["id"], $_POST["dia"], $_POST["inicio"], $_POST["fin"]);
    header("Location: list.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
    <h2>Editar Disponibilidad</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $datos['ID_DISPONIBILIDAD'] ?>">
        <div class="mb-3">
            <label>Día</label>
            <input type="text" name="dia" class="form-control" value="<?= $datos['DIA_SEMANA'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Hora Inicio</label>
            <input type="text" name="inicio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Hora Fin</label>
            <input type="text" name="fin" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</main>
<?php PrintFooter(); ?>
</body>
</html>
