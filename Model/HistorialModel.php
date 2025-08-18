<?php
require_once __DIR__ . '/OracleHelper.php';

class HistorialModel extends OracleHelper {

  /** Normaliza cursor/array a array de filas */
  private function rowsFrom($maybe) {
    $out = [];
    if (is_object($maybe) && get_class($maybe) === 'OCIStatement') {
      while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
    } elseif (is_resource($maybe)) {
      while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
    } elseif (is_array($maybe)) { $out = $maybe; }
    return $out;
  }

  /** Lista todos los historiales (array seguro para las vistas) */
  public function listar(): array {
    $cur = $this->execCursor("BEGIN pkg_historial.sp_listar(:cur); END;");
    return $this->rowsFrom($cur);
  }

  /**
   * No hay sp_obtener; resolvemos en PHP.
   * (Pequeño y suficiente para esta app; si lo necesitas muy a menudo, conviene crear sp_obtener en la BD.)
   */
  public function obtener($id) {
    $rows = $this->listar();
    foreach ($rows as $r) {
      if ((int)$r['ID_HISTORIAL'] === (int)$id) return $r;
    }
    return null;
  }

  /** Crear usando el paquete: el ID se autogenera si llega NULL */
  public function crear(array $d): int {
    $id = null; // IN OUT
    $this->execProc("BEGIN pkg_historial.sp_crear(:id,:p,:c,:dx,:tx); END;", [
      ":id" => $id,                     // el SP lo rellena (SEQ_HISTORIAL)
      ":p"  => $d['ID_PACIENTE'],
      ":c"  => $d['ID_CITA'],
      ":dx" => $d['DIAGNOSTICO'],
      ":tx" => $d['TRATAMIENTO']
    ]);
    return (int)$id;
  }

  /** Actualiza solo diagnóstico y tratamiento (firma real del SP) */
  public function actualizar(array $d): void {
    $this->execProc("BEGIN pkg_historial.sp_actualizar(:id,:dx,:tx); END;", [
      ":id" => $d['ID_HISTORIAL'],
      ":dx" => $d['DIAGNOSTICO'],
      ":tx" => $d['TRATAMIENTO']
    ]);
  }

  public function eliminar($id): void {
    $this->execProc("BEGIN pkg_historial.sp_eliminar(:id); END;", [":id" => $id]);
  }
}
