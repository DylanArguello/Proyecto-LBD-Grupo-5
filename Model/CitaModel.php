<?php
class CitaModel {
    public $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT C.ID_CITA, P.NOMBRE AS PACIENTE, D.NOMBRE AS DOCTOR, C.FECHA, TO_CHAR(C.HORA, 'HH24:MI') AS HORA, C.ESTADO
                FROM CITA C
                JOIN PACIENTE P ON C.ID_PACIENTE = P.ID_PACIENTE
                JOIN DOCTOR D ON C.ID_DOCTOR = D.ID_DOCTOR
                ORDER BY C.FECHA, C.HORA";
        $stmt = oci_parse($this->conn, $sql);
        oci_execute($stmt);
        return $stmt;
    }

    public function getById($id) {
        $sql = "SELECT * FROM CITA WHERE ID_CITA = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        return oci_fetch_assoc($stmt);
    }

    public function insert($data) {
        $sql = "INSERT INTO CITA (ID_CITA, ID_PACIENTE, ID_DOCTOR, FECHA, HORA, ESTADO)
                VALUES (:id, :paciente, :doctor, TO_DATE(:fecha, 'YYYY-MM-DD'), TO_DATE(:hora, 'HH24:MI'), :estado)";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $data['id']);
        oci_bind_by_name($stmt, ":paciente", $data['paciente']);
        oci_bind_by_name($stmt, ":doctor", $data['doctor']);
        oci_bind_by_name($stmt, ":fecha", $data['fecha']);
        oci_bind_by_name($stmt, ":hora", $data['hora']);
        oci_bind_by_name($stmt, ":estado", $data['estado']);
        return oci_execute($stmt);
    }

    public function update($data) {
        $sql = "UPDATE CITA SET ID_PACIENTE = :paciente, ID_DOCTOR = :doctor,
                FECHA = TO_DATE(:fecha, 'YYYY-MM-DD'), HORA = TO_DATE(:hora, 'HH24:MI'), ESTADO = :estado
                WHERE ID_CITA = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $data['id']);
        oci_bind_by_name($stmt, ":paciente", $data['paciente']);
        oci_bind_by_name($stmt, ":doctor", $data['doctor']);
        oci_bind_by_name($stmt, ":fecha", $data['fecha']);
        oci_bind_by_name($stmt, ":hora", $data['hora']);
        oci_bind_by_name($stmt, ":estado", $data['estado']);
        return oci_execute($stmt);
    }

    public function delete($id) {
        $sql = "DELETE FROM CITA WHERE ID_CITA = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        return oci_execute($stmt);
    }
}
?>
