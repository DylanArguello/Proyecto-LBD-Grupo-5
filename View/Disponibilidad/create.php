<?php
include_once "../../Controller/DisponibilidadController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $disponibilidadModel->insertar($_POST["id"], $_POST["doctor"], $_POST["dia"], $_POST["inicio"], $_POST["fin"]);
    header("Location: list.php");
}
$doctores = $disponibilidadModel->obtenerDoctores();
?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
    <h2>Nueva Disponibilidad</h2>
    <form method="post">
        <div class="mb-3">
            <label>ID Disponibilidad</label>
            <input type="number" name="id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Doctor</label>
            <select name="doctor" class="form-control" required>
                <?php while ($doc = oci_fetch_assoc($doctores)) {
                    echo "<option value='{$doc['ID_DOCTOR']}'>{$doc['NOMBRE']}</option>";
                } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Día de la Semana</label>
            <input type="text" name="dia" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Hora Inicio (HH:MM)</label>
            <input type="text" name="inicio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Hora Fin (HH:MM)</label>
            <input type="text" name="fin" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</main>
<?php PrintFooter(); ?>
</body>
</html>
