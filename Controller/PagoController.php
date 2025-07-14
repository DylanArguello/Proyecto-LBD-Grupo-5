<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Proyecto-LBD-Grupo-5/Model/PagoModel.php";

$conn = oci_connect($usuario, $contrasena, $cadena_conexion);  
$pagoModel  = new PagoModel($conn);