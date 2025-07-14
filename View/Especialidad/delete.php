<?php
include_once "../../Controller/EspecialidadController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

$id = $_GET["id"];
$especialidadModel->eliminar($id);
header("Location: list.php");
?>
