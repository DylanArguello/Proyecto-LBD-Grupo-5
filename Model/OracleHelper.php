<?php
// Model/OracleHelper.php
// -----------------------------------------------------------------------------
// Versión ajustada a tu proyecto:
// - Usa conexion_oracle.php para obtener $conn
// - Silencia warnings de oci_execute() y lanza AppException amigable
// - Soporta OUT params simples (pasa null en el bind)
// - execCursor() retorna ARRAY de filas (assoc)
// -----------------------------------------------------------------------------

require_once __DIR__ . '/../Utils/AppErrors.php';

class OracleHelper {
  /** @var resource|\OCIConnection */
  protected $conn;

  public function __construct() {
    // Tu archivo debe definir $conn (recurso de conexión)
    require __DIR__ . '/conexion_oracle.php';
    if (!isset($conn) || !$conn) {
      throw new AppException('Sin conexión Oracle.');
    }
    $this->conn = $conn;
  }

  /** Bindea todos los parámetros IN/OUT (OUT = null => reserva buffer) */
  private function bindAll($stid, array &$binds): void {
    foreach ($binds as $name => &$val) {
      // OUT o IN OUT simples -> pasar como null y reservar buffer
      if ($val === null) {
        oci_bind_by_name($stid, $name, $binds[$name], 4000); // buffer cómodo para VARCHAR2/NUMBER
      } else {
        oci_bind_by_name($stid, $name, $binds[$name]);
      }
    }
  }

  /** Lanza AppException amigable a partir de un statement/cnx */
  private function throwFromOci($handle): void {
    $e = oci_error($handle) ?: oci_error($this->conn) ?: ['message' => 'Error OCI'];
    throw AppErrors::fromOracleArray($e); // -> AppException
  }

  /** Ejecuta un bloque PL/SQL sin cursor (BEGIN ... END;) */
  protected function execProc(string $plsql, array $binds = []) {
    $stid = oci_parse($this->conn, $plsql);
    if (!$stid) $this->throwFromOci($this->conn);

    $this->bindAll($stid, $binds);

    // Silenciamos warnings del driver y transformamos el error
    $ok = @oci_execute($stid);
    if (!$ok) $this->throwFromOci($stid);

    return $stid; // compatibilidad (normalmente no lo usas)
  }

  /** Ejecuta un bloque PL/SQL que retorna SYS_REFCURSOR y devuelve array de filas */
  protected function execCursor(string $plsql, array $binds = []) : array {
    $stid = oci_parse($this->conn, $plsql);
    if (!$stid) $this->throwFromOci($this->conn);

    // Cursor de salida estándar ':cur'
    $cur = oci_new_cursor($this->conn);
    oci_bind_by_name($stid, ':cur', $cur, -1, OCI_B_CURSOR);

    // Otros parámetros
    $this->bindAll($stid, $binds);

    // Ejecutar statement y luego el cursor
    $ok = @oci_execute($stid);
    if (!$ok) $this->throwFromOci($stid);

    $okCur = @oci_execute($cur);
    if (!$okCur) $this->throwFromOci($cur);

    // Leer filas y cerrar cursor
    $rows = [];
    while ($r = oci_fetch_assoc($cur)) {
      $rows[] = $r;
    }

    oci_free_statement($cur);
    // (no cerramos $stid por si el caller quiere inspeccionarlo; Oracle lo libera al fin de request)

    return $rows;
  }
}
