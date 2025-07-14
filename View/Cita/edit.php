<?php
require_once "../../Controller/CitaController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

$id = $_GET['id'];
$data = $cita->getById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datos = [
        'id' => $id,
        'paciente' => $_POST['paciente'],
        'doctor' => $_POST['doctor'],
        'fecha' => $_POST['fecha'],
        'hora' => $_POST['hora'],
        'estado' => $_POST['estado']
    ];
    $cita->update($datos);
    header("Location: list.php");
    exit;
}
?>

<h2>Editar Cita</h2>
<form method="post">
    <input type="number" name="paciente" value="<?= $data['ID_PACIENTE'] ?>" class="form-control mb-2">
    <input type="number" name="doctor" value="<?= $data['ID_DOCTOR'] ?>" class="form-control mb-2">
    <input type="date" name="fecha" value="<?= date('Y-m-d', strtotime($data['FECHA'])) ?>" class="form-control mb-2">
    <input type="time" name="hora" value="<?= date('H:i', strtotime($data['HORA'])) ?>" class="form-control mb-2">
    <input type="text" name="estado" value="<?= $data['ESTADO'] ?>" class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
