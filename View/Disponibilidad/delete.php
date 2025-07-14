<?php
include_once "../../Controller/DisponibilidadController.php";
$id = $_GET["id"];
$disponibilidadModel->eliminar($id);
header("Location: list.php");
?>
