<?php
require_once '../../Controller/recordatorioController.php';
$id = $_GET['id'];
$controller = new RecordatorioController();
$controller->destroy($id);
header("Location: list.php");
?>
