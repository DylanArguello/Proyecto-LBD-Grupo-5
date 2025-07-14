<?php
class PacienteModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM PACIENTE ORDER BY NOMBRE";
        $stmt = oci_parse($this->conn, $sql);
        oci_execute($stmt);
        return $stmt;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM PACIENTE WHERE ID_PACIENTE = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        return oci_fetch_assoc($stmt);
    }

    public function insertar($id, $nombre, $email, $telefono, $direccion) {
        $sql = "INSERT INTO PACIENTE (ID_PACIENTE, NOMBRE, EMAIL, TELEFONO, DIRECCION)
                VALUES (:id, :nombre, :email, :telefono, :direccion)";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":email", $email);
        oci_bind_by_name($stmt, ":telefono", $telefono);
        oci_bind_by_name($stmt, ":direccion", $direccion);
        return oci_execute($stmt);
    }

    public function actualizar($id, $nombre, $email, $telefono, $direccion) {
        $sql = "UPDATE PACIENTE SET NOMBRE = :nombre, EMAIL = :email, TELEFONO = :telefono, DIRECCION = :direccion
                WHERE ID_PACIENTE = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":email", $email);
        oci_bind_by_name($stmt, ":telefono", $telefono);
        oci_bind_by_name($stmt, ":direccion", $direccion);
        return oci_execute($stmt);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM PACIENTE WHERE ID_PACIENTE = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        return oci_execute($stmt);
    }
}
?>
