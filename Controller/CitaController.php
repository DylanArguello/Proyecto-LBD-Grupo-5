<?php
// Controller/CitaController.php
require_once __DIR__ . '/../Model/CitaModel.php';
require_once __DIR__ . '/../Model/PacienteModel.php';
require_once __DIR__ . '/../Model/DoctorModel.php';
require_once __DIR__ . '/../Model/DisponibilidadModel.php';

$citaModel     = new CitaModel();
$pacienteModel = new PacienteModel();
$doctorModel   = new DoctorModel();

/* ========= Helpers compartidos (se definen una sola vez) ========= */
if (!function_exists('rows_from')) {
  function rows_from($maybe) {
    $out = [];
    if (is_object($maybe) && get_class($maybe) === 'OCIStatement') {
      while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
    } elseif (is_resource($maybe)) {
      while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
    } elseif (is_array($maybe)) { $out = $maybe; }
    return $out;
  }
}
if (!function_exists('toIsoDate')) {
  function toIsoDate(?string $v): string {
    $v = trim((string)$v);
    if ($v === '') return '';
    if (preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $v, $m)) {
      return sprintf('%04d-%02d-%02d', (int)$m[3], (int)$m[2], (int)$m[1]);
    }
    return $v; // ya viene 'YYYY-MM-DD'
  }
}
if (!function_exists('toHHMM')) {
  function toHHMM(?string $v): string {
    $v = preg_replace('/[^0-9:]/', '', (string)$v);
    return substr($v, 0, 5); // HH:MM
  }
}
if (!function_exists('diaFromDate')) {
  function diaFromDate(string $isoDate): string {
    $w = (int)date('w', strtotime($isoDate)); // 0=Dom .. 6=Sáb
    $dias = ['DOMINGO','LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO'];
    return $dias[$w] ?? '';
  }
}

/* ========= Validación de disponibilidad ========= */
if (!function_exists('doctor_tiene_disponibilidad')) {
  function doctor_tiene_disponibilidad(int $idDoctor, string $fechaIso, string $horaHHMM, DisponibilidadModel $dispModel): bool {
    $dia  = diaFromDate($fechaIso);
    $disps = rows_from($dispModel->listar());
    foreach ($disps as $d) {
      if ((int)$d['ID_DOCTOR'] === $idDoctor && strtoupper($d['DIA_SEMANA']) === $dia) {
        $ini = substr($d['HORA_INICIO'] ?? '', 0, 5);
        $fin = substr($d['HORA_FIN'] ?? '', 0, 5);
        if ($horaHHMM >= $ini && $horaHHMM <= $fin) return true;
      }
    }
    return false;
  }
}

/* ========= Caso de uso: Editar Cita =========
   Retorna un "view model" con todo lo que la vista necesita.
*/
function cita_handle_edit(array $query, array $post): array {
  global $citaModel, $pacienteModel, $doctorModel;
  $dispModel = new DisponibilidadModel();

  $vm = [
    'error'     => '',
    'item'      => null,
    'pacientes' => [],
    'doctores'  => [],
    'dispon'    => [],
    'fecha_val' => '',
    'hora_val'  => '',
    'estados'   => ['AGENDADA','CONFIRMADA','CANCELADA'],
  ];

  $id = isset($query['id']) ? (int)$query['id'] : 0;
  if ($id <= 0) { header("Location: list.php"); exit; }

  // Eliminar (opcional)
  if (isset($query['delete'])) {
    try {
      $citaModel->eliminar($id); // sin forzar
      header("Location: list.php"); exit;
    } catch (Throwable $t) {
      $vm['error'] = $t->getMessage();
    }
  }

  // Actualizar
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPaciente = (int)($post['ID_PACIENTE'] ?? 0);
    $idDoctor   = (int)($post['ID_DOCTOR']   ?? 0);
    $fechaIso   = toIsoDate($post['FECHA'] ?? '');
    $horaHHMM   = toHHMM($post['HORA'] ?? '');
    $estado     = $post['ESTADO'] ?? 'AGENDADA';

    try {
      if (!doctor_tiene_disponibilidad($idDoctor, $fechaIso, $horaHHMM, $dispModel)) {
        $dia = strtolower(diaFromDate($fechaIso));
        $vm['error'] = "El doctor no tiene disponibilidad el $dia a las $horaHHMM. Elige un horario válido o agrega disponibilidad.";
      } else {
        $citaModel->actualizar([
          'ID_CITA'     => $id,
          'ID_PACIENTE' => $idPaciente,
          'ID_DOCTOR'   => $idDoctor,
          'FECHA'       => $fechaIso,
          'HORA'        => $horaHHMM,
          'ESTADO'      => $estado,
        ]);
        header("Location: list.php"); exit;
      }
    } catch (Throwable $t) {
      $vm['error'] = $t->getMessage();
    }
  }

  // Cargar datos para la vista (si hay error, igual intentamos cargar)
  try {
    $vm['item']      = $citaModel->obtener($id);
    $vm['pacientes'] = rows_from($pacienteModel->listar());
    $vm['doctores']  = rows_from($doctorModel->listar());
    $vm['dispon']    = rows_from($dispModel->listar());
    $vm['fecha_val'] = toIsoDate($vm['item']['FECHA'] ?? '');
    $vm['hora_val']  = toHHMM($vm['item']['HORA'] ?? '');
  } catch (Throwable $t) {
    $vm['error'] = $vm['error'] ?: $t->getMessage();
  }

  return $vm;
}
