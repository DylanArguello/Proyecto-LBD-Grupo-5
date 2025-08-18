<?php
include_once __DIR__ . "/../../Controller/DoctorController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

$error=''; try{$especialidades=$especialidadModel->listar();}catch(Throwable $t){$error=$t->getMessage();$especialidades=[];}
if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $doctorModel->crear([
      'NOMBRE'=>$_POST['NOMBRE']??'',
      'TELEFONO'=>$_POST['TELEFONO']??'',
      'ID_ESPECIALIDAD'=>$_POST['ID_ESPECIALIDAD']??'',
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){$error=$t->getMessage();}
}
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Nuevo Doctor</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post">
  <label class="form-label">Nombre</label><input class="form-control mb-2" name="NOMBRE" required>
  <label class="form-label">Teléfono</label><input class="form-control mb-2" name="TELEFONO">
  <label class="form-label">Especialidad</label>
  <select class="form-select mb-3" name="ID_ESPECIALIDAD" required>
    <option value="">-- Seleccione --</option>
    <?php foreach($especialidades as $e): ?>
    <option value="<?=htmlspecialchars($e['ID_ESPECIALIDAD'])?>"><?=htmlspecialchars($e['NOMBRE'])?></option>
    <?php endforeach; ?>
  </select>
  <button class="btn btn-success">Guardar</button> <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>

<?php PrintFooter(); ?>