<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";

class CitaModel {
    private $conn;

    public function __construct($conn) {
        global $conn;
        $this->conn = $conn;
    }

public function getAll() {
    $sql = "SELECT 
              C.ID_CITA, 
              P.NOMBRE AS PACIENTE, 
              D.NOMBRE AS DOCTOR, 
              TO_CHAR(C.FECHA, 'YYYY-MM-DD') AS FECHA, 
              TO_CHAR(C.HORA, 'HH24:MI') AS HORA, 
              C.ESTADO
            FROM CITA C
            JOIN PACIENTE P ON C.ID_PACIENTE = P.ID_PACIENTE
            JOIN DOCTOR D ON C.ID_DOCTOR = D.ID_DOCTOR
            ORDER BY C.FECHA, C.HORA";
    $stmt = oci_parse($this->conn, $sql);
    oci_execute($stmt);
    $citas = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $citas[] = $row;
    }
    return $citas;
}

    public function getById($id) {
        $sql = "SELECT * FROM CITA WHERE ID_CITA = :id";
        $stmt = oci_parse($this->conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        return oci_fetch_assoc($stmt);
    }

public function create($data) {
    $sql = "INSERT INTO CITA
              (ID_CITA, ID_PACIENTE, ID_DOCTOR, ID_ESPECIALIDAD,
               FECHA,              HORA,              ESTADO)
            VALUES
              (:ID_CITA, :ID_PACIENTE, :ID_DOCTOR, :ID_ESPECIALIDAD,
               TO_DATE(:FECHA,'YYYY-MM-DD'),
               TO_DATE(:HORA ,'HH24:MI'),
               :ESTADO)";
    $stmt = oci_parse($this->conn, $sql);
    foreach ($data as $k => &$v) {
        oci_bind_by_name($stmt, ":$k", $v);
    }

    if (!oci_execute($stmt)) {
        $e = oci_error($stmt);
        throw new Exception("Error al insertar cita: ".$e['message']);
    }
    oci_commit($this->conn);
    return true;
}

public function update($data) {
    $sql = "UPDATE CITA
              SET ID_PACIENTE    = :ID_PACIENTE,
                  ID_DOCTOR      = :ID_DOCTOR,
                  ID_ESPECIALIDAD= :ID_ESPECIALIDAD,
                  FECHA          = TO_DATE(:FECHA,'YYYY-MM-DD'),
                  HORA           = TO_DATE(:HORA ,'HH24:MI'),
                  ESTADO         = :ESTADO
            WHERE ID_CITA        = :ID_CITA";
    $stmt = oci_parse($this->conn, $sql);
    foreach ($data as $k => &$v) {
        oci_bind_by_name($stmt, ":$k", $v);
    }

    if (!oci_execute($stmt)) {
        $e = oci_error($stmt);
        throw new Exception("Error al actualizar cita: ".$e['message']);
    }
    oci_commit($this->conn);
    return true;
}




public function getNextId() {
    $sql = "SELECT NVL(MAX(ID_CITA), 0) + 1 AS NEXT_ID FROM CITA";
    $stmt = oci_parse($this->conn, $sql);
    oci_execute($stmt);
    $row = oci_fetch_assoc($stmt);
    return $row["NEXT_ID"];
}


    public function getPacientes() {
        $stmt = oci_parse($this->conn, "SELECT ID_PACIENTE, NOMBRE FROM PACIENTE ORDER BY NOMBRE");
        oci_execute($stmt);
        $data = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getDoctores() {
        $stmt = oci_parse($this->conn, "SELECT ID_DOCTOR, NOMBRE FROM DOCTOR ORDER BY NOMBRE");
        oci_execute($stmt);
        $data = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getEspecialidades() {
        $stmt = oci_parse($this->conn, "SELECT ID_ESPECIALIDAD, NOMBRE FROM ESPECIALIDAD ORDER BY NOMBRE");
        oci_execute($stmt);
        $data = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $data[] = $row;
        }
        return $data;
    }
}
?>
