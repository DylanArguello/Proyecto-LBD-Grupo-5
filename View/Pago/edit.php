<?php include_once "../../Controller/PagoController.php";

$datos = $pagoModel->obtenerPorId($_GET['id']);

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $pagoModel->actualizar([
        'id'     => $datos['ID_PAGO'],
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
  <h2>Editar Pago</h2>
  <form method="post">
    <input class="form-control mb-2" type="number" step="0.01" name="monto"
           value="<?= $datos['MONTO'] ?>" required>
    <input class="form-control mb-2" type="date"   name="fecha"
           value="<?= date('Y-m-d', strtotime($datos['FECHA'])) ?>" required>
    <input class="form-control mb-3" type="text"   name="metodo"
           value="<?= $datos['METODO_PAGO'] ?>" required>
    <button class="btn btn-primary">Actualizar</button>
    <a href="list.php" class="btn btn-secondary">Cancelar</a>
  </form>
</main>
<?php PrintFooter(); ?>
</body></html>
