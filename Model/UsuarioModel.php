<?php
class UsuarioModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM USUARIO ORDER BY NOMBRE_USUARIO";
        $st = oci_parse($this->conn, $sql);
        oci_execute($st);
        return $st;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM USUARIO WHERE ID_USUARIO = :id";
        $st = oci_parse($this->conn, $sql);
        oci_bind_by_name($st, ":id", $id);
        oci_execute($st);
        return oci_fetch_assoc($st);
    }

    public function crear($datos) {
        $sql = "INSERT INTO USUARIO (ID_USUARIO, NOMBRE_USUARIO, CONTRASENA, TIPO_USUARIO)
                VALUES (:id, :nombre, :clave, :tipo)";
        $st = oci_parse($this->conn, $sql);
        oci_bind_by_name($st, ":id",     $datos['id']);
        oci_bind_by_name($st, ":nombre", $datos['nombre']);
        oci_bind_by_name($st, ":clave",  $datos['clave']);
        oci_bind_by_name($st, ":tipo",   $datos['tipo']);
        return oci_execute($st);
    }

    public function actualizar($datos) {
        $sql = "UPDATE USUARIO
                   SET NOMBRE_USUARIO = :nombre,
                       CONTRASENA     = :clave,
                       TIPO_USUARIO   = :tipo
                 WHERE ID_USUARIO     = :id";
        $st = oci_parse($this->conn, $sql);
        oci_bind_by_name($st, ":nombre", $datos['nombre']);
        oci_bind_by_name($st, ":clave",  $datos['clave']);
        oci_bind_by_name($st, ":tipo",   $datos['tipo']);
        oci_bind_by_name($st, ":id",     $datos['id']);
        return oci_execute($st);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM USUARIO WHERE ID_USUARIO = :id";
        $st = oci_parse($this->conn, $sql);
        oci_bind_by_name($st, ":id", $id);
        return oci_execute($st);
    }
}
?>
