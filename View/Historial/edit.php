<?php
include_once __DIR__ . "/../../Controller/HistorialController.php";
$id=$_GET['id']??null; if(!$id){header("Location: list.php");exit;}
$error='';
if(isset($_GET['delete'])){ try{$historialModel->eliminar($id); header("Location: list.php"); exit;}catch(Throwable $t){$error=$t->getMessage();} }
try{ $item=$historialModel->obtener($id); }catch(Throwable $t){ $error=$t->getMessage(); $item=null; }
if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $historialModel->actualizar([
      'ID_HISTORIAL'=>$id,
      'DIAGNOSTICO'=>$_POST['DIAGNOSTICO']??'',
      'TRATAMIENTO'=>$_POST['TRATAMIENTO']??'',
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){ $error=$t->getMessage(); }
}
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Editar Historial</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<div class="mb-2"><strong>ID Paciente:</strong> <?=htmlspecialchars($item['ID_PACIENTE']??'')?></div>
<div class="mb-3"><strong>ID Cita:</strong> <?=htmlspecialchars($item['ID_CITA']??'')?></div>
<form method="post">
  <label class="form-label">Diagnóstico</label><textarea class="form-control mb-2" name="DIAGNOSTICO" rows="3" required><?=htmlspecialchars($item['DIAGNOSTICO']??'')?></textarea>
  <label class="form-label">Tratamiento</label><textarea class="form-control mb-3" name="TRATAMIENTO" rows="3" required><?=htmlspecialchars($item['TRATAMIENTO']??'')?></textarea>
  <button class="btn btn-success">Actualizar</button> <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>
