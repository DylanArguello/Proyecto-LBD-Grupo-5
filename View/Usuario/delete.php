<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/UsuarioModel.php";

$conn = oci_connect($usuario, $contrasena, $cadena_conexion);
if (!$conn) { $e = oci_error(); die("Error de DB: ".$e['message']); }
$usuarioModel = new UsuarioModel($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id) { $usuarioModel->eliminar($id); }

header("Location: list.php");
exit;
