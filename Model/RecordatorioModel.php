<?php
// Model/RecordatorioModel.php
require_once __DIR__ . '/OracleHelper.php';

class RecordatorioModel extends OracleHelper {

  /** Lista: usa el paquete (ya devuelve FECHA_ENVIO como 'YYYY-MM-DD') */
  public function listar(): array {
    return $this->execCursor("BEGIN PKG_RECORDATORIO.sp_listar(:cur); END;");
  }

  /** Crear: usa OUT id del paquete (no dependemos de SP_GENERAR_ID_RECORDATORIO) */
public function crear(array $d): int {
  $id = null; // IN OUT
  // Orden correcto: cita, mensaje, fecha, id
  $this->execProc("BEGIN PKG_RECORDATORIO.sp_crear_recordatorio(:cita,:msg,:fecha,:id); END;", [
    ":cita"  => $d['ID_CITA'],
    ":msg"   => $d['MENSAJE'],
    ":fecha" => $d['FECHA_ENVIO'], // 'YYYY-MM-DD'
    ":id"    => $id,
  ]);
  return (int)$id;
}


  /** Reprogramar: fecha string 'YYYY-MM-DD' */
  public function reprogramar($id, $fecha): void {
    $this->execProc("BEGIN PKG_RECORDATORIO.sp_reprogramar(:id,:fecha); END;", [
      ":id" => $id, ":fecha" => $fecha
    ]);
  }

  /** Cancelar (eliminar registro) */
  public function cancelar($id): void {
    $this->execProc("BEGIN PKG_RECORDATORIO.sp_cancelar(:id); END;", [":id"=>$id]);
  }

  /** Conveniencia: obtener uno (no hay sp_obtener en el paquete) */
  public function obtener($id) {
    foreach ($this->listar() as $r) {
      if ((int)$r['ID_RECORDATORIO'] === (int)$id) return $r;
    }
    return null;
  }
}
