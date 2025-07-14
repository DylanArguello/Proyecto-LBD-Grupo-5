<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/HistorialModel.php";

$model = new HistorialModel();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["create"])) {
        $model->insert([
            ":ID" => $_POST["id"],
            ":PACIENTE" => $_POST["paciente"],
            ":CITA" => $_POST["cita"],
            ":DIAGNOSTICO" => $_POST["diagnostico"],
            ":TRATAMIENTO" => $_POST["tratamiento"]
        ]);
    } elseif (isset($_POST["update"])) {
        $model->update([
            ":ID" => $_POST["id"],
            ":DIAGNOSTICO" => $_POST["diagnostico"],
            ":TRATAMIENTO" => $_POST["tratamiento"]
        ]);
    } elseif (isset($_POST["delete"])) {
        $model->delete($_POST["id"]);
    }

    header("Location: /Proyecto-LBD-Grupo-5/views/Historial/list.php");
    exit;
}
