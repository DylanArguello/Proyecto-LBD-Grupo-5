<?php
class EspecialidadModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodas() {
        $sql = "SELECT * FROM ESPECIALIDAD ORDER BY NOMBRE";
        $stmt = oci_parse($this->conn, $sql);
        oci_execute($stmt);
        return $stmt;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM ESPECIALIDAD WHERE ID_ESPECIALIDAD = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        return oci_fetch_assoc($stmt);
    }

    public function insertar($id, $nombre) {
        $sql = "INSERT INTO ESPECIALIDAD (ID_ESPECIALIDAD, NOMBRE) VALUES (:id, :nombre)";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        return oci_execute($stmt);
    }

    public function actualizar($id, $nombre) {
        $sql = "UPDATE ESPECIALIDAD SET NOMBRE = :nombre WHERE ID_ESPECIALIDAD = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":id", $id);
        return oci_execute($stmt);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM ESPECIALIDAD WHERE ID_ESPECIALIDAD = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        return oci_execute($stmt);
    }
}
?>
