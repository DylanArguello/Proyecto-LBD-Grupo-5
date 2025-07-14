<?php
include "../../Controller/HistorialController.php";
$id = $_GET["id"];
$model->delete($id);
header("Location: list.php");
