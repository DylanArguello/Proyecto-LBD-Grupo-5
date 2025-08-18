<?php
require_once __DIR__ . '/../Model/DoctorModel.php';
require_once __DIR__ . '/../Model/EspecialidadModel.php';

$doctorModel       = new DoctorModel();
$especialidadModel = new EspecialidadModel();
// Uso en vistas:
//   $doctorModel->listar(), ->crear($data), ->actualizar($data), ->eliminar($id)
//   $especialidadModel->listar()   // para combos de especialidad
