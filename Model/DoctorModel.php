<?php
require_once __DIR__ . '/OracleHelper.php';

class DoctorModel extends OracleHelper {

  public function listar(): array {
    return $this->execCursor("BEGIN pkg_doctor.sp_listar_doctores(:cur); END;");
  }

  public function listarPorEspecialidad($idEsp): array {
    return $this->execCursor(
      "BEGIN pkg_doctor.sp_listar_doctores_especialidad(:esp,:cur); END;",
      [":esp"=>$idEsp]
    );
  }

  public function crear(array $d): int {
    $id = null; // OUT
    $this->execProc("BEGIN pkg_doctor.sp_crear_doctor(:n,:tel,:esp,:id); END;", [
      ":n"   => $d['NOMBRE'] ?? '',
      ":tel" => $d['TELEFONO'] ?? '',
      ":esp" => $d['ID_ESPECIALIDAD'] ?? '',
      ":id"  => $id
    ]);
    return (int)$id;
  }

  public function actualizar(array $d): void {
    $this->execProc("BEGIN pkg_doctor.sp_actualizar_doctor(:id,:n,:tel,:esp); END;", [
      ":id"  => $d['ID_DOCTOR'],
      ":n"   => $d['NOMBRE'] ?? '',
      ":tel" => $d['TELEFONO'] ?? '',
      ":esp" => $d['ID_ESPECIALIDAD'] ?? ''
    ]);
  }

  public function eliminar($id): void {
    $this->execProc("BEGIN pkg_doctor.sp_eliminar_doctor(:id); END;", [":id"=>$id]);
  }
}
