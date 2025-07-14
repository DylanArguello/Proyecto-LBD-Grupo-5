<?php
include_once "../../Controller/DoctorController.php";

$id = $_GET["id"];
$doctorModel->eliminar($id);
header("Location: list.php");
?>
