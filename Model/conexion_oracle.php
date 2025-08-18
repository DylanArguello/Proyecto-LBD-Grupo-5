<?php
$usuario = "PROYECTO";
$contrasena = "proyecto123";
$cadena_conexion = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    (CONNECT_DATA =
      (SERVICE_NAME = XEPDB1)
    )
)";

$conn = oci_connect($usuario, $contrasena, $cadena_conexion);

if (!$conn) {
    $e = oci_error();
    die("Error al conectar: " . htmlentities($e['message'], ENT_QUOTES));
}