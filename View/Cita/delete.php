<?php
require_once "../../Controller/CitaController.php";
$id = $_GET['id'];
$cita->delete($id);
header("Location: list.php");
exit;
?>
