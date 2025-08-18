<?php
require_once __DIR__ . '/OracleHelper.php';

class PacienteModel extends OracleHelper {

  public function listar(): array {
    return $this->execCursor("BEGIN pkg_paciente.sp_listar(:cur); END;");
  }

  public function obtener($id) {
    $rows = $this->execCursor("BEGIN pkg_paciente.sp_obtener(:id,:cur); END;", [":id"=>$id]);
    return $rows[0] ?? null;
  }

  public function crear(array $d): int {
    $id = null;
    $this->execProc("BEGIN pkg_paciente.sp_crear(:id,:n,:e,:t,:dir); END;", [
      ":id"=>$id, ":n"=>$d['NOMBRE'], ":e"=>$d['EMAIL'],
      ":t"=>$d['TELEFONO'], ":dir"=>$d['DIRECCION']
    ]);
    return (int)$id;
  }

  public function actualizar(array $d): void {
    $this->execProc("BEGIN pkg_paciente.sp_actualizar(:id,:n,:e,:t,:dir); END;", [
      ":id"=>$d['ID_PACIENTE'], ":n"=>$d['NOMBRE'], ":e"=>$d['EMAIL'],
      ":t"=>$d['TELEFONO'], ":dir"=>$d['DIRECCION']
    ]);
  }

  public function eliminar($id): void {
    $this->execProc("BEGIN pkg_paciente.sp_eliminar(:id); END;", [":id"=>$id]);
  }
}
