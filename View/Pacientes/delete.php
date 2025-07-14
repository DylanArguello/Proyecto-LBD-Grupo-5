<?php
include_once "../../Controller/PacienteController.php";
$id = $_GET["id"];
$pacienteModel->eliminar($id);
header("Location: list.php");
?>
