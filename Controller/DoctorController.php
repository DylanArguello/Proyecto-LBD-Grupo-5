<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/DoctorModel.php";

$conn = oci_connect($usuario, $contrasena, $cadena_conexion);
$doctorModel = new DoctorModel($conn);
?>
