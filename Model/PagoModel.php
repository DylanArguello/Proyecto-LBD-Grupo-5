<?php
require_once __DIR__ . '/OracleHelper.php';

class PagoModel extends OracleHelper {

  /** Normaliza cursor/array a array de filas */
  private function rowsFrom($maybe) {
    $out = [];
    if (is_object($maybe) && get_class($maybe) === 'OCIStatement') {
      while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
    } elseif (is_resource($maybe)) {
      while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
    } elseif (is_array($maybe)) {
      $out = $maybe;
    }
    return $out;
  }

  /** Lista con nombre de paciente (JOIN lo hace el SP) */
  public function listar(): array {
    $cur  = $this->execCursor("BEGIN SP_OBTENER_PAGOS(:cur); END;");
    $rows = $this->rowsFrom($cur);
    foreach ($rows as &$r) {              // alias amigables para la vista
      if (isset($r['FECHA']))       $r['FECHA_PAGO'] = $r['FECHA'];
      if (isset($r['METODO_PAGO'])) $r['METODO']     = $r['METODO_PAGO'];
    }
    return $rows;
  }

  public function obtener($id) {
    $cur  = $this->execCursor("BEGIN SP_OBTENER_PAGO_POR_ID(:id,:cur); END;", [":id"=>$id]);
    $rows = $this->rowsFrom($cur);
    return $rows[0] ?? null;
  }

  /** Crear pago usando PKG_PAGO (sin OUT de estado, fecha en VARCHAR2) */
  public function crear(array $d): int {
    $id = null; // el paquete lo rellena si llega NULL
    $this->execProc(
      "BEGIN PKG_PAGO.sp_crear_pago(:cita,:monto,:f,:metodo,:id); END;",
      [
        ":cita"   => $d['ID_CITA'],
        ":monto"  => $d['MONTO'],
        ":f"      => $d['FECHA_PAGO'], // 'YYYY-MM-DD' del <input type="date">
        ":metodo" => $d['METODO'],
        ":id"     => $id               // IN OUT
      ]
    );
    return (int)$id;
  }

  /** Actualizar pago con PKG_PAGO */
  public function actualizar(array $d): void {
    $this->execProc(
      "BEGIN PKG_PAGO.sp_actualizar_pago(:id,:monto,:f,:metodo); END;",
      [
        ":id"     => $d['ID_PAGO'],
        ":monto"  => $d['MONTO'],
        ":f"      => $d['FECHA_PAGO'], // 'YYYY-MM-DD'
        ":metodo" => $d['METODO']
      ]
    );
  }

  /** Eliminar pago con PKG_PAGO */
  public function eliminar($id): void {
    $this->execProc("BEGIN PKG_PAGO.sp_eliminar_pago(:id); END;", [":id"=>$id]);
  }
}
