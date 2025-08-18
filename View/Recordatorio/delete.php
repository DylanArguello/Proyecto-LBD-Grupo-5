<?php
require_once __DIR__ . "/../../Controller/RecordatorioController.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header("Location: list.php"); exit; }

try {
  $controller = new RecordatorioController();
  $controller->destroy($id);
  header("Location: list.php"); exit;
} catch (Throwable $t) {
  if (session_status() === PHP_SESSION_NONE) session_start();
  $_SESSION['flash_error'] = $t->getMessage();
  header("Location: list.php"); exit;
}
