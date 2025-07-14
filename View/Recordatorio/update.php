<?php
require_once '../../Controller/recordatorioController.php';

$data = [
    'id' => $_POST['id'],
    'cita' => $_POST['cita'],
    'mensaje' => $_POST['mensaje'],
    'fecha' => $_POST['fecha']
];

$controller = new RecordatorioController();
$controller->update($data);
header("Location: list.php");
?>
