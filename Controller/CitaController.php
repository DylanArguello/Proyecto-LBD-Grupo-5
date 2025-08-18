<?php
require_once __DIR__ . '/../Model/CitaModel.php';
require_once __DIR__ . '/../Model/PacienteModel.php';
require_once __DIR__ . '/../Model/DoctorModel.php';

$citaModel     = new CitaModel();
$pacienteModel = new PacienteModel();
$doctorModel   = new DoctorModel();
// Métodos: $citaModel->listar(), ->obtener($id), ->crear($data), ->actualizar($data), ->eliminar($id)
