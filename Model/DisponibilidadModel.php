<?php
require_once __DIR__ . '/OracleHelper.php';

class DisponibilidadModel extends OracleHelper {

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

  /** Extrae HH:MM de cualquier string de fecha/hora */
  private function fmtHora($v) {
    if ($v === null) return null;
    $s = (string)$v;
    if (preg_match('/\b(\d{2}:\d{2})\b/', $s, $m)) return $m[1]; // 13:45, 13:45:00, 2025-01-01 13:45:00
    return $s; // si ya viene como HH:MM o un texto legible
  }

  /**
   * Lista SIN SQL directo en PHP.
   * Usa el paquete y luego formatea horas en PHP a 'HH:MM' para la UI.
   */
  public function listar(): array {
    $cur  = $this->execCursor("BEGIN pkg_disponibilidad.sp_listar_disponibilidad(:cur); END;");
    $rows = $this->rowsFrom($cur);
    foreach ($rows as &$r) {
      if (isset($r['HORA_INICIO'])) $r['HORA_INICIO'] = $this->fmtHora($r['HORA_INICIO']);
      if (isset($r['HORA_FIN']))    $r['HORA_FIN']    = $this->fmtHora($r['HORA_FIN']);
    }
    return $rows;
  }

  /** Crear: el paquete genera ID si llega NULL; horas como DATE vía TO_DATE en PL/SQL */
  public function crear(array $d): int {
    $id = null; // IN OUT (autogenera la secuencia si es NULL)
    $this->execProc(
      "BEGIN pkg_disponibilidad.sp_crear_disponibilidad(:id,:doc,:dia,TO_DATE(:ini,'HH24:MI'),TO_DATE(:fin,'HH24:MI')); END;",
      [
        ":id"  => $id,
        ":doc" => $d['ID_DOCTOR'],
        ":dia" => $d['DIA_SEMANA'],
        ":ini" => $d['HORA_INICIO'], // 'HH:MM' del <input type="time">
        ":fin" => $d['HORA_FIN']     // 'HH:MM'
      ]
    );
    return (int)$id;
  }

  /** Actualizar: mismas conversiones de hora */
  public function actualizar(array $d): void {
    $this->execProc(
      "BEGIN pkg_disponibilidad.sp_actualizar_disponibilidad(:id,:doc,:dia,TO_DATE(:ini,'HH24:MI'),TO_DATE(:fin,'HH24:MI')); END;",
      [
        ":id"  => $d['ID_DISPONIBILIDAD'],
        ":doc" => $d['ID_DOCTOR'],
        ":dia" => $d['DIA_SEMANA'],
        ":ini" => $d['HORA_INICIO'],
        ":fin" => $d['HORA_FIN']
      ]
    );
  }

  public function eliminar($id): void {
    $this->execProc("BEGIN pkg_disponibilidad.sp_eliminar_disponibilidad(:id); END;", [":id" => $id]);
  }
}
