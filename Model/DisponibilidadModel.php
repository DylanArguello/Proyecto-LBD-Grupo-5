<?php
class DisponibilidadModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodas() {
        $sql = "SELECT DISP.ID_DISPONIBILIDAD, DISP.DIA_SEMANA, DISP.HORA_INICIO, DISP.HORA_FIN,
                       DR.ID_DOCTOR, DR.NOMBRE AS NOMBRE_DOCTOR
                FROM DISPONIBILIDAD DISP
                JOIN DOCTOR DR ON DISP.ID_DOCTOR = DR.ID_DOCTOR
                ORDER BY DR.NOMBRE, DISP.DIA_SEMANA";
        $stmt = oci_parse($this->conn, $sql);
        oci_execute($stmt);
        return $stmt;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM DISPONIBILIDAD WHERE ID_DISPONIBILIDAD = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        return oci_fetch_assoc($stmt);
    }

    public function insertar($id, $doctor_id, $dia, $inicio, $fin) {
        $sql = "INSERT INTO DISPONIBILIDAD (ID_DISPONIBILIDAD, ID_DOCTOR, DIA_SEMANA, HORA_INICIO, HORA_FIN)
                VALUES (:id, :doctor_id, :dia, TO_DATE(:inicio, 'HH24:MI'), TO_DATE(:fin, 'HH24:MI'))";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_bind_by_name($stmt, ":doctor_id", $doctor_id);
        oci_bind_by_name($stmt, ":dia", $dia);
        oci_bind_by_name($stmt, ":inicio", $inicio);
        oci_bind_by_name($stmt, ":fin", $fin);
        return oci_execute($stmt);
    }

    public function actualizar($id, $dia, $inicio, $fin) {
        $sql = "UPDATE DISPONIBILIDAD SET DIA_SEMANA = :dia,
                 HORA_INICIO = TO_DATE(:inicio, 'HH24:MI'),
                 HORA_FIN = TO_DATE(:fin, 'HH24:MI') WHERE ID_DISPONIBILIDAD = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":dia", $dia);
        oci_bind_by_name($stmt, ":inicio", $inicio);
        oci_bind_by_name($stmt, ":fin", $fin);
        oci_bind_by_name($stmt, ":id", $id);
        return oci_execute($stmt);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM DISPONIBILIDAD WHERE ID_DISPONIBILIDAD = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        return oci_execute($stmt);
    }

    public function obtenerDoctores() {
        $sql = "SELECT ID_DOCTOR, NOMBRE FROM DOCTOR ORDER BY NOMBRE";
        $stmt = oci_parse($this->conn, $sql);
        oci_execute($stmt);
        return $stmt;
    }
}
?>
