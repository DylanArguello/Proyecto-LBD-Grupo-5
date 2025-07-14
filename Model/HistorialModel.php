<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/HistorialModel.php";

class HistorialModel extends BaseModel {
    public function getAll() {
        $sql = "SELECT * FROM V_Historial ORDER BY FECHA DESC";
        return $this->selectAll($sql);
    }

    public function getById($id) {
        $sql = "SELECT * FROM Historial_MEDICO WHERE ID_Historial = :ID";
        return $this->selectOne($sql, [":ID" => $id]);
    }

    public function insert($data) {
        $sql = "INSERT INTO Historial_MEDICO (ID_Historial, ID_PACIENTE, ID_CITA, DIAGNOSTICO, TRATAMIENTO)
                VALUES (:ID, :PACIENTE, :CITA, :DIAGNOSTICO, :TRATAMIENTO)";
        return $this->execute($sql, $data);
    }

    public function update($data) {
        $sql = "UPDATE Historial_MEDICO SET DIAGNOSTICO = :DIAGNOSTICO, TRATAMIENTO = :TRATAMIENTO WHERE ID_Historial = :ID";
        return $this->execute($sql, $data);
    }

    public function delete($id) {
        $sql = "DELETE FROM Historial_MEDICO WHERE ID_Historial = :ID";
        return $this->execute($sql, [":ID" => $id]);
    }

    public function getPacientes() {
        return $this->selectAll("SELECT ID_PACIENTE, NOMBRE FROM PACIENTE ORDER BY NOMBRE");
    }

    public function getCitas() {
        return $this->selectAll("SELECT ID_CITA FROM CITA ORDER BY FECHA DESC");
    }
}
