<?php
class AppException extends Exception {
  public $field;       // Campo afectado (opcional)
  public $oracle_code; // "00001", "01400", etc. (opcional)
  function __construct($message, $field = null, $oracle_code = null) {
    parent::__construct($message);
    $this->field = $field;
    $this->oracle_code = $oracle_code;
  }
}

class AppErrors {
  /** Convierte un array de oci_error() en AppException amigable */
  public static function fromOracleArray(array $e): AppException {
    $msg = $e['message'] ?? 'Error de base de datos';
    $ora = null;
    if (preg_match('/ORA-(\d{5})/i', $msg, $m)) $ora = $m[1];

    // Intenta extraer columna de "ORA-01400: cannot insert NULL into (SCHEMA.TABLE.COL)"
    $col = null;
    if (preg_match('/\((?:[^.]+\.){2}([^)\s]+)\)/', $msg, $m)) $col = strtoupper($m[1] ?? '');

    switch ($ora) {
      case '00001': // unique constraint violated
        return new AppException('Este Email ya está registrado. Modifícalo e intenta nuevamente.',
                                self::fieldHintFromMsg($msg), $ora);

      case '02291': // parent key not found
        return new AppException('El registro relacionado no existe. Revisa las selecciones (p. ej., paciente, doctor, cita).',
                                null, $ora);

      case '02292': // child record found
        return new AppException('No se puede eliminar porque tiene información relacionada.',
                                null, $ora);

      case '01400': // cannot insert NULL
        return new AppException('Falta completar un campo obligatorio.',
                                $col, $ora);

      case '06502': // numeric or value error (longitud / conversión)
        return new AppException('Alguno de los campos supera la longitud permitida o tiene formato inválido.',
                                $col, $ora);

      case '01843': // mes no válido
      case '01861': // literal does not match format string
        return new AppException('Fecha u hora con formato inválido. Usa fecha YYYY-MM-DD y hora HH:MM.',
                                $col, $ora);

      case '00932': // tipos incompatibles
        return new AppException('Tipo de dato inválido. Verifica lo ingresado.',
                                $col, $ora);

      default:
        // No exponemos detalles técnicos al usuario
        return new AppException('Ocurrió un error y no pudimos completar la operación. Inténtalo de nuevo.',
                                $col, $ora);
    }
  }

  /** Sugiere campo probable para ORA-00001 con base en el texto */
  public static function fieldHintFromMsg(string $msg): ?string {
    $u = strtoupper($msg);
    foreach (['EMAIL','CORREO','USUARIO','NOMBRE_USUARIO','DNI','CEDULA','RUC'] as $key) {
      if (strpos($u, $key) !== false) return $key;
    }
    return null;
  }
}
