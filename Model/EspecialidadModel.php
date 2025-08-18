<?php
require_once __DIR__ . '/OracleHelper.php';

class EspecialidadModel extends OracleHelper {

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

  /** Lista todas las especialidades (array seguro para las vistas) */
  public function listar(): array {
    $cur = $this->execCursor("BEGIN pkg_especialidad.sp_listar(:cur); END;");
    return $this->rowsFrom($cur); // evita foreach sobre cursor
  }

  /** Crear usando el paquete: el ID se autogenera si llega NULL */
  public function crear(string $nombre): int {
    $id = null;
    $this->execProc("BEGIN pkg_especialidad.sp_crear(:id,:n); END;", [
      ":id" => $id,          // IN OUT: el paquete rellena si es NULL
      ":n"  => $nombre
    ]);
    return (int)$id;
  }

  /** Actualizar nombre */
  public function actualizar(array $d): void {
    $this->execProc("BEGIN pkg_especialidad.sp_actualizar(:id,:n); END;", [
      ":id" => $d['ID_ESPECIALIDAD'],
      ":n"  => $d['NOMBRE']
    ]);
  }

  /** Eliminar por ID */
  public function eliminar($id): void {
    $this->execProc("BEGIN pkg_especialidad.sp_eliminar(:id); END;", [":id" => $id]);
  }
}
