<?php
include_once __DIR__ . "/../../Controller/DisponibilidadController.php";
$id=$_GET['id']??null; if(!$id){header("Location: list.php");exit;}
$error='';
if(isset($_GET['delete'])){ try{$disponibilidadModel->eliminar($id); header("Location: list.php"); exit;}catch(Throwable $t){$error=$t->getMessage();} }
try{
  $items=$disponibilidadModel->listar(); $item=null; foreach($items as $r){ if((int)$r['ID_DISPONIBILIDAD']==(int)$id){$item=$r;break;}}
  $doctores=$doctorModel->listar();
}catch(Throwable $t){$error=$t->getMessage(); $item=null; $doctores=[];}
if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $disponibilidadModel->actualizar([
      'ID_DISPONIBILIDAD'=>$id,
      'ID_DOCTOR'=>$_POST['ID_DOCTOR']??'',
      'DIA_SEMANA'=>$_POST['DIA_SEMANA']??'',
      'HORA_INICIO'=>$_POST['HORA_INICIO']??'',
      'HORA_FIN'=>$_POST['HORA_FIN']??'',
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){$error=$t->getMessage();}
}
$dias=['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO'];
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Editar Disponibilidad</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post">
  <label class="form-label">Doctor</label>
  <select class="form-select mb-2" name="ID_DOCTOR" required>
    <option value="">-- Seleccione --</option>
    <?php $cur=$item['ID_DOCTOR']??''; foreach($doctores as $d): ?>
    <option value="<?=htmlspecialchars($d['ID_DOCTOR'])?>" <?=($cur==$d['ID_DOCTOR'])?'selected':''?>><?=htmlspecialchars($d['NOMBRE'])?></option>
    <?php endforeach; ?>
  </select>
  <label class="form-label">Día de la semana</label>
  <select class="form-select mb-2" name="DIA_SEMANA" required>
    <?php $cd=$item['DIA_SEMANA']??''; foreach($dias as $d): ?><option value="<?=$d?>" <?=($cd===$d)?'selected':''?>><?=$d?></option><?php endforeach;?>
  </select>
  <label class="form-label">Hora Inicio</label><input class="form-control mb-2" type="time" name="HORA_INICIO" value="<?=htmlspecialchars(substr($item['HORA_INICIO']??'',0,5))?>" required>
  <label class="form-label">Hora Fin</label><input class="form-control mb-3" type="time" name="HORA_FIN" value="<?=htmlspecialchars(substr($item['HORA_FIN']??'',0,5))?>" required>
  <button class="btn btn-success">Actualizar</button> <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>

<?php PrintFooter(); ?>
