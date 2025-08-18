<?php
require_once __DIR__ . '/../Model/HistorialModel.php';
require_once __DIR__ . '/../Model/CitaModel.php';
require_once __DIR__ . '/../Model/PacienteModel.php';

$historialModel = new HistorialModel();
$citaModel      = new CitaModel();
$pacienteModel  = new PacienteModel();
// Métodos: $historialModel->listar(), ->obtener($id), ->crear($data), ->actualizar($data), ->eliminar($id)
