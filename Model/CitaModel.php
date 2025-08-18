<?php
require_once __DIR__ . '/OracleHelper.php';

class CitaModel extends OracleHelper {

  /* === Lecturas === */
  public function listar(): array {
    return $this->execCursor("BEGIN PKG_CITA.sp_listar(:cur); END;");
  }

  public function obtener($id) {
    $rows = $this->execCursor("BEGIN PKG_CITA.sp_obtener(:id,:cur); END;", [":id" => $id]);
    return $rows[0] ?? null;
  }

  /* === Escrituras (usan PKG_CITA y envían fecha/hora como texto) === */
  public function crear(array $d): int {
    $id = null;
    $this->execProc(
      "BEGIN PKG_CITA.sp_crear(:p,:d,:f,:h,:e,:id); END;",
      [
        ":p"  => (string)$d['ID_PACIENTE'],   // 'YYYY-MM-DD' / 'HH:MM' ya vienen normalizados desde la vista
        ":d"  => (string)$d['ID_DOCTOR'],
        ":f"  => (string)$d['FECHA'],
        ":h"  => (string)$d['HORA'],
        ":e"  => (string)$d['ESTADO'],
        ":id" => &$id,                        // OUT
      ]
    );
    return (int)$id;
  }

  public function actualizar(array $d): void {
    $this->execProc(
      "BEGIN PKG_CITA.sp_actualizar(:id,:p,:d,:f,:h,:e); END;",
      [
        ":id" => (string)$d['ID_CITA'],
        ":p"  => (string)$d['ID_PACIENTE'],
        ":d"  => (string)$d['ID_DOCTOR'],
        ":f"  => (string)$d['FECHA'],   // 'YYYY-MM-DD'
        ":h"  => (string)$d['HORA'],    // 'HH:MM'
        ":e"  => (string)$d['ESTADO'],
      ]
    );
  }

  /* === Eliminación === */
  public function eliminar($id, bool $forzar = false): void {
    if ($forzar) {
      $status = null;
      $this->execProc(
        "BEGIN PKG_CITA.sp_eliminar_safe(:id,:force,:status); END;",
        [":id" => $id, ":force" => 1, ":status" => &$status]
      );
      if ($status !== 'OK') {
        throw new Exception('No se pudo eliminar la cita (tiene relacionados).');
      }
    } else {
      $this->execProc("BEGIN PKG_CITA.sp_eliminar(:id); END;", [":id" => $id]);
    }
  }
}
