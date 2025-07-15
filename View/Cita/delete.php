<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/CitaModel.php";

$model = new CitaModel($conn);
$model->delete($_GET["id"] ?? 0);

header("Location: list.php");
exit();
