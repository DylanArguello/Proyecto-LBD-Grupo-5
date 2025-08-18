<?php
include_once __DIR__ . "/../../Controller/PagoController.php";
$id=$_GET['id']??null; if(!$id){header("Location: list.php");exit;}
$error='';

if(isset($_GET['delete'])){ try{$pagoModel->eliminar($id); header("Location: list.php"); exit;}catch(Throwable $t){$error=$t->getMessage();} }

try{ $item=$pagoModel->obtener($id); $citas=$citaModel->listar(); }catch(Throwable $t){ $error=$t->getMessage(); $item=null; $citas=[]; }

if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $pagoModel->actualizar([
      'ID_PAGO'=>$id,
      'MONTO'=>$_POST['MONTO']??'',
      'FECHA_PAGO'=>$_POST['FECHA_PAGO']??'',
      'METODO'=>$_POST['METODO']??'',
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){ $error=$t->getMessage(); }
}
$metodos=['EFECTIVO','TARJETA','TRANSFERENCIA'];
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Editar Pago</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<div class="mb-2"><strong>Cita:</strong>
  <?php
    $label=''; foreach($citas as $c){ if((int)$c['ID_CITA']==(int)($item['ID_CITA']??0)){ $label=(($c['PACIENTE']??'').' - '.($c['FECHA']??'').' '.substr($c['HORA']??'',0,5)); break; } }
    echo htmlspecialchars($label ?: ($item['ID_CITA']??''));
  ?>
</div>
<form method="post">
  <label class="form-label">Monto</label><input class="form-control mb-2" name="MONTO" type="number" step="0.01" min="0" value="<?=htmlspecialchars($item['MONTO']??'')?>" required>
  <label class="form-label">Fecha de pago</label><input class="form-control mb-2" name="FECHA_PAGO" type="date" value="<?=htmlspecialchars($item['FECHA_PAGO']??'')?>" required>
  <label class="form-label">Método</label>
  <select class="form-select mb-3" name="METODO" required>
    <?php $cm=$item['METODO']??''; foreach($metodos as $m): ?><option value="<?=$m?>" <?=($cm===$m)?'selected':''?>><?=$m?></option><?php endforeach;?>
  </select>
  <button class="btn btn-success">Actualizar</button> <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>
