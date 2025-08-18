<?php
include_once __DIR__ . "/../../Controller/EspecialidadController.php";
$id=$_GET['id']??null; if(!$id){header("Location: list.php");exit;}
$error='';
if(isset($_GET['delete'])){ try{$especialidadModel->eliminar($id); header("Location: list.php"); exit;}catch(Throwable $t){$error=$t->getMessage();} }
if($_SERVER['REQUEST_METHOD']==='POST'){
  try{ $especialidadModel->actualizar(['ID_ESPECIALIDAD'=>$id,'NOMBRE'=>$_POST['NOMBRE']??'']); header("Location: list.php"); exit; }
  catch(Throwable $t){ $error=$t->getMessage(); }
}
try{$items=$especialidadModel->listar(); $item=null; foreach($items as $r){ if((int)$r['ID_ESPECIALIDAD']==(int)$id){$item=$r; break;}}}catch(Throwable $t){$error=$t->getMessage();}
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Editar Especialidad</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post">
  <label class="form-label">Nombre</label><input class="form-control mb-3" name="NOMBRE" value="<?=htmlspecialchars($item['NOMBRE']??'')?>" required>
  <button class="btn btn-success">Actualizar</button> <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>
