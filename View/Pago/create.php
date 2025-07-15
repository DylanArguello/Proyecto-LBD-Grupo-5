<?php include_once "../../Controller/PagoController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $pagoModel->crear([
        'id'     => $_POST['id'],
        'cita'   => $_POST['cita'],
        'monto'  => $_POST['monto'],
        'fecha'  => $_POST['fecha'],
        'metodo' => $_POST['metodo']
    ]);
    header("Location: list.php"); exit;
}
?>
<!DOCTYPE html><html lang="es">
<?php PrintCss(); ?>
<body><?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Registrar Pago</h2>
  <form method="post">
    <input class="form-control mb-2" type="number" name="id"     placeholder="ID Pago"   required>
    <input class="form-control mb-2" type="number" name="cita"   placeholder="ID Cita"   required>
    <input class="form-control mb-2" type="number" step="0.01" name="monto"  placeholder="Monto"    required>
    <input class="form-control mb-2" type="date"   name="fecha"  required>
    <input class="form-control mb-3" type="text"   name="metodo" placeholder="Método"    required>
    <button class="btn btn-success">Guardar</button>
    <a href="list.php" class="btn btn-secondary">Cancelar</a>
  </form>
</main>
<?php PrintFooter(); ?>
</body></html>

