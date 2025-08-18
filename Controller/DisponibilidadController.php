<?php
require_once __DIR__ . '/../Model/DisponibilidadModel.php';
require_once __DIR__ . '/../Model/DoctorModel.php';

$disponibilidadModel = new DisponibilidadModel();
$doctorModel         = new DoctorModel();
// Métodos: $disponibilidadModel->listar(), ->crear($data), ->actualizar($data), ->eliminar($id)
//          $doctorModel->listar()
