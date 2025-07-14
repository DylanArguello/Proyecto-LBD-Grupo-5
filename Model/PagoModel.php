<?php
class PagoModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $sql = "SELECT P.ID_PAGO,
                       P.ID_CITA,
                       PAC.NOMBRE   AS PACIENTE,
                       P.MONTO,
                       TO_CHAR(P.FECHA,'YYYY-MM-DD') AS FECHA,
                       P.METODO_PAGO
                  FROM PAGO  P
                  JOIN CITA  C   ON P.ID_CITA     = C.ID_CITA
                  JOIN PACIENTE PAC ON C.ID_PACIENTE = PAC.ID_PACIENTE
              ORDER BY P.FECHA DESC";
        $st = oci_parse($this->conn, $sql);
        oci_execute($st);
        return $st;            
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM PAGO WHERE ID_PAGO = :id";
        $st  = oci_parse($this->conn, $sql);
        oci_bind_by_name($st, ":id", $id);
        oci_execute($st);
        return oci_fetch_assoc($st);
    }

    public function crear($datos) {
        $sql = "INSERT INTO PAGO (ID_PAGO, ID_CITA, MONTO, FECHA, METODO_PAGO)
                VALUES (:id, :cita, :monto, TO_DATE(:fecha, 'YYYY-MM-DD'), :metodo)";
        $st  = oci_parse($this->conn, $sql);
        oci_bind_by_name($st, ":id",     $datos['id']);
        oci_bind_by_name($st, ":cita",   $datos['cita']);
        oci_bind_by_name($st, ":monto",  $datos['monto']);
        oci_bind_by_name($st, ":fecha",  $datos['fecha']);
        oci_bind_by_name($st, ":metodo", $datos['metodo']);
        return oci_execute($st);
    }

    public function actualizar($datos) {
        $sql = "UPDATE PAGO
                   SET MONTO = :monto,
                       FECHA = TO_DATE(:fecha, 'YYYY-MM-DD'),
                       METODO_PAGO = :metodo
                 WHERE ID_PAGO = :id";
        $st  = oci_parse($this->conn, $sql);
        oci_bind_by_name($st, ":monto",  $datos['monto']);
        oci_bind_by_name($st, ":fecha",  $datos['fecha']);
        oci_bind_by_name($st, ":metodo", $datos['metodo']);
        oci_bind_by_name($st, ":id",     $datos['id']);
        return oci_execute($st);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM PAGO WHERE ID_PAGO = :id";
        $st  = oci_parse($this->conn, $sql);
        oci_bind_by_name($st, ":id", $id);
        return oci_execute($st);
    }
}
?>
