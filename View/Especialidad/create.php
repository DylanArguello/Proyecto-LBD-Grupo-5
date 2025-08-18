<?php
include_once __DIR__ . "/../../Controller/EspecialidadController.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
$error=''; if($_SERVER['REQUEST_METHOD']==='POST'){try{$especialidadModel->crear($_POST['NOMBRE']??''); header("Location: list.php"); exit;}catch(Throwable $t){$error=$t->getMessage();}}
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Nueva Especialidad</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post">
  <label class="form-label">Nombre</label><input class="form-control mb-3" name="NOMBRE" required>
  <button class="btn btn-success">Guardar</button> <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>

<?php PrintFooter(); ?>