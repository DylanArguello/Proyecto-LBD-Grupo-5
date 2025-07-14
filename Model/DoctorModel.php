<?php
class DoctorModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $sql = "SELECT D.ID_DOCTOR, D.NOMBRE, D.TELEFONO, E.NOMBRE AS ESPECIALIDAD
                FROM DOCTOR D
                LEFT JOIN ESPECIALIDAD E ON D.ID_ESPECIALIDAD = E.ID_ESPECIALIDAD
                ORDER BY D.NOMBRE";
        $stmt = oci_parse($this->conn, $sql);
        oci_execute($stmt);
        return $stmt;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM DOCTOR WHERE ID_DOCTOR = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        return oci_fetch_assoc($stmt);
    }

    public function obtenerEspecialidades() {
        $sql = "SELECT ID_ESPECIALIDAD, NOMBRE FROM ESPECIALIDAD ORDER BY NOMBRE";
        $stmt = oci_parse($this->conn, $sql);
        oci_execute($stmt);
        return $stmt;
    }

    public function insertar($id, $nombre, $telefono, $id_especialidad) {
        $sql = "INSERT INTO DOCTOR (ID_DOCTOR, NOMBRE, TELEFONO, ID_ESPECIALIDAD)
                VALUES (:id, :nombre, :telefono, :idesp)";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":telefono", $telefono);
        oci_bind_by_name($stmt, ":idesp", $id_especialidad);
        return oci_execute($stmt);
    }

    public function actualizar($id, $nombre, $telefono, $id_especialidad) {
        $sql = "UPDATE DOCTOR SET NOMBRE = :nombre, TELEFONO = :telefono, ID_ESPECIALIDAD = :idesp
                WHERE ID_DOCTOR = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":telefono", $telefono);
        oci_bind_by_name($stmt, ":idesp", $id_especialidad);
        oci_bind_by_name($stmt, ":id", $id);
        return oci_execute($stmt);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM DOCTOR WHERE ID_DOCTOR = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        return oci_execute($stmt);
    }
}
?>
