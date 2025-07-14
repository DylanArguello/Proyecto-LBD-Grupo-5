<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/DisponibilidadModel.php";

$conn = oci_connect($usuario, $contrasena, $cadena_conexion);
$disponibilidadModel = new DisponibilidadModel($conn);
?>
