<?php
include_once __DIR__ . "/../../Controller/PacienteController.php";

$id = $_GET['id'] ?? null; if(!$id){ header("Location: list.php"); exit; }
$error='';

if(isset($_GET['delete'])){
  try{ $pacienteModel->eliminar($id); header("Location: list.php"); exit; }catch(Throwable $t){ $error=$t->getMessage(); }
}

if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $pacienteModel->actualizar([
      'ID_PACIENTE'=>$id,
      'NOMBRE'=>$_POST['NOMBRE']??'',
      'EMAIL'=>$_POST['EMAIL']??'',
      'TELEFONO'=>$_POST['TELEFONO']??'',
      'DIRECCION'=>$_POST['DIRECCION']??'',
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){ $error=$t->getMessage(); }
}

try{ $item = $pacienteModel->obtener($id); }catch(Throwable $t){ $error=$t->getMessage(); $item=null; }
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Editar Paciente</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post">
  <label class="form-label">Nombre</label><input class="form-control mb-2" name="NOMBRE" value="<?=htmlspecialchars($item['NOMBRE']??'')?>" required>
  <label class="form-label">Email</label><input class="form-control mb-2" type="email" name="EMAIL" value="<?=htmlspecialchars($item['EMAIL']??'')?>">
  <label class="form-label">Teléfono</label><input class="form-control mb-2" name="TELEFONO" value="<?=htmlspecialchars($item['TELEFONO']??'')?>">
  <label class="form-label">Dirección</label><input class="form-control mb-3" name="DIRECCION" value="<?=htmlspecialchars($item['DIRECCION']??'')?>">
  <button class="btn btn-success">Actualizar</button> <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>

<?php PrintFooter(); ?>