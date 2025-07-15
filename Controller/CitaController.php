<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/CitaModel.php";

$model = new CitaModel($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? '';

    $idCita = $_POST["ID_CITA"] ?: $model->getNextId();

    $data = [
        "ID_CITA"        => $idCita,
        "ID_PACIENTE"    => $_POST["ID_PACIENTE"],
        "ID_DOCTOR"      => $_POST["ID_DOCTOR"],
        "ID_ESPECIALIDAD"=> $_POST["ID_ESPECIALIDAD"],
        "FECHA"          => $_POST["FECHA"],
        "HORA"           => $_POST["HORA"],
        "ESTADO"         => $_POST["ESTADO"]
    ];

    if ($action === "create") {
        $model->create($data);
    } elseif ($action === "update") {
        $model->update($data);
    }
    header("Location: /Proyecto-LBD-Grupo-5/View/Cita/list.php");
    exit();
}

if (isset($_GET["action"]) && $_GET["action"] === "delete") {
    $model->delete($_GET["id"]);
    header("Location: /Proyecto-LBD-Grupo-5/View/Cita/list.php");
    exit();
}
