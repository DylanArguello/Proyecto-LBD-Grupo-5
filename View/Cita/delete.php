<?php
// View/Cita/delete.php
include_once __DIR__ . "/../../Controller/CitaController.php";

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) { header("Location: list.php"); exit; }

try {
  // Eliminación segura (sin forzar). Cambia a true si quieres cascade controlado.
  $citaModel->eliminar($id, false); // PKG_CITA.sp_eliminar
  header("Location: list.php"); exit;
} catch (Throwable $t) {
  // Si no se pudo por tener relacionados, puedes redirigir con un mensaje
  // o forzar: $citaModel->eliminar($id, true);
  header("Location: list.php?err=" . urlencode($t->getMessage())); exit;
}