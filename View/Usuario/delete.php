<?php
include_once "../../Controller/UsuarioController.php";
$usuarioModel->eliminar($_GET['id']);
header("Location: list.php");
?>