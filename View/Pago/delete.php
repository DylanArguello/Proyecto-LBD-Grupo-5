<?php
include_once "../../Controller/PagoController.php";
$pagoModel->eliminar($_GET['id']);
header("Location: list.php");
?>
