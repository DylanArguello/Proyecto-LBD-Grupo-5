<?php
require_once __DIR__ . '/OracleHelper.php';

class CitaModel extends OracleHelper {

  // Listar usando los SP standalone que devuelven nombres
  public function listar(): array {
    return $this->execCursor("BEGIN SP_LISTAR_CITAS_NOMBRES(:cur); END;");
  }

  public function obtener($id) {
    $rows = $this->execCursor("BEGIN SP_OBTENER_CITA_NOMBRES(:id,:cur); END;", [":id"=>$id]);
    return $rows[0] ?? null;
  }

  public function crear(array $d): int {
    $id = null;
    $this->execProc(
      "BEGIN PKG_CITA.sp_crear(:id,:p,:d, TO_DATE(:f,'YYYY-MM-DD'), TO_DATE(:h,'HH24:MI'), :e); END;",
      [
        ":id" => $id,
        ":p"  => $d['ID_PACIENTE'],
        ":d"  => $d['ID_DOCTOR'],
        ":f"  => $d['FECHA'],               // 'YYYY-MM-DD'
        ":h"  => $d['HORA'],                // 'HH:MI'
        ":e"  => $d['ESTADO']
      ]
    );
    return (int)$id;
  }

  public function actualizar(array $d): void {
    $this->execProc(
      "BEGIN PKG_CITA.sp_actualizar(:id,:p,:d, TO_DATE(:f,'YYYY-MM-DD'), TO_DATE(:h,'HH24:MI'), :e); END;",
      [
        ":id" => $d['ID_CITA'],
        ":p"  => $d['ID_PACIENTE'],
        ":d"  => $d['ID_DOCTOR'],
        ":f"  => $d['FECHA'],               // 'YYYY-MM-DD'
        ":h"  => $d['HORA'],                // 'HH:MI'
        ":e"  => $d['ESTADO']
      ]
    );
  }

  public function eliminar($id): void {
    $this->execProc("BEGIN PKG_CITA.sp_eliminar(:id); END;", [":id"=>$id]);
  }
}
