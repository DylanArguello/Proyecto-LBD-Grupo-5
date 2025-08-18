<?php
include_once __DIR__ . "/../../Controller/DoctorController.php";
$id=$_GET['id']??null; if(!$id){header("Location: list.php");exit;}
$error='';
if(isset($_GET['delete'])){ try{$doctorModel->eliminar($id); header("Location: list.php"); exit;}catch(Throwable $t){$error=$t->getMessage();} }
if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $doctorModel->actualizar([
      'ID_DOCTOR'=>$id,
      'NOMBRE'=>$_POST['NOMBRE']??'',
      'TELEFONO'=>$_POST['TELEFONO']??'',
      'ID_ESPECIALIDAD'=>$_POST['ID_ESPECIALIDAD']??'',
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){$error=$t->getMessage();}
}
try{$item=$doctorModel->listar(); $doc=null; foreach($item as $r){ if((int)$r['ID_DOCTOR']==(int)$id){$doc=$r;break;}}
    $especialidades=$especialidadModel->listar();
}catch(Throwable $t){$error=$t->getMessage(); $doc=null; $especialidades=[];}
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Editar Doctor</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post">
  <label class="form-label">Nombre</label><input class="form-control mb-2" name="NOMBRE" value="<?=htmlspecialchars($doc['NOMBRE']??'')?>" required>
  <label class="form-label">Teléfono</label><input class="form-control mb-2" name="TELEFONO" value="<?=htmlspecialchars($doc['TELEFONO']??'')?>">
  <label class="form-label">Especialidad</label>
  <select class="form-select mb-3" name="ID_ESPECIALIDAD" required>
    <option value="">-- Seleccione --</option>
    <?php $cur=$doc['ID_ESPECIALIDAD']??''; foreach($especialidades as $e): ?>
    <option value="<?=htmlspecialchars($e['ID_ESPECIALIDAD'])?>" <?=($cur==$e['ID_ESPECIALIDAD'])?'selected':''?>><?=htmlspecialchars($e['NOMBRE'])?></option>
    <?php endforeach; ?>
  </select>
  <button class="btn btn-success">Actualizar</button> <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>
