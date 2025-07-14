<?php
require_once __DIR__ . '/../config/database.php';

class RecordatorioModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $query = "SELECT R.ID_RECORDATORIO, C.ID_CITA, P.NOMBRE AS PACIENTE, C.FECHA, C.HORA, R.MENSAJE, R.FECHA_ENVIO
                  FROM RECORDATORIO R
                  JOIN CITA C ON R.ID_CITA = C.ID_CITA
                  JOIN PACIENTE P ON C.ID_PACIENTE = P.ID_PACIENTE
                  ORDER BY R.FECHA_ENVIO DESC";
        $stmt = oci_parse($this->conn, $query);
        oci_execute($stmt);
        $result = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $result[] = $row;
        }
        return $result;
    }

    public function getById($id) {
        $query = "SELECT * FROM RECORDATORIO WHERE ID_RECORDATORIO = :id";
        $stmt = oci_parse($this->conn, $query);
        oci_bind_by_name($stmt, ':id', $id);
        oci_execute($stmt);
        return oci_fetch_assoc($stmt);
    }

    public function create($data) {
        $query = "INSERT INTO RECORDATORIO (ID_RECORDATORIO, ID_CITA, MENSAJE, FECHA_ENVIO)
                  VALUES (:id, :cita, :mensaje, TO_DATE(:fecha, 'YYYY-MM-DD'))";
        $stmt = oci_parse($this->conn, $query);
        oci_bind_by_name($stmt, ':id', $data['id']);
        oci_bind_by_name($stmt, ':cita', $data['cita']);
        oci_bind_by_name($stmt, ':mensaje', $data['mensaje']);
        oci_bind_by_name($stmt, ':fecha', $data['fecha']);
        return oci_execute($stmt);
    }

    public function update($data) {
        $query = "UPDATE RECORDATORIO
                  SET ID_CITA = :cita, MENSAJE = :mensaje, FECHA_ENVIO = TO_DATE(:fecha, 'YYYY-MM-DD')
                  WHERE ID_RECORDATORIO = :id";
        $stmt = oci_parse($this->conn, $query);
        oci_bind_by_name($stmt, ':id', $data['id']);
        oci_bind_by_name($stmt, ':cita', $data['cita']);
        oci_bind_by_name($stmt, ':mensaje', $data['mensaje']);
        oci_bind_by_name($stmt, ':fecha', $data['fecha']);
        return oci_execute($stmt);
    }

    public function delete($id) {
        $query = "DELETE FROM RECORDATORIO WHERE ID_RECORDATORIO = :id";
        $stmt = oci_parse($this->conn, $query);
        oci_bind_by_name($stmt, ':id', $id);
        return oci_execute($stmt);
    }
}
?>
