<?php
include_once __DIR__ . "/../../Controller/UsuarioController.php";
$id=$_GET['id']??null; if(!$id){header("Location: list.php");exit;}
$error=''; $tipos=['ADMIN','RECEPCIONISTA','DOCTOR'];

if(isset($_GET['delete'])){ try{$usuarioModel->eliminar($id); header("Location: list.php"); exit;}catch(Throwable $t){$error=$t->getMessage();} }

try{ $items=$usuarioModel->listar(); $item=null; foreach($items as $r){ if((int)$r['ID_USUARIO']==(int)$id){$item=$r;break;}} }catch(Throwable $t){ $error=$t->getMessage(); }

if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $usuarioModel->actualizar([
      'ID_USUARIO'=>$id,
      'NOMBRE_USUARIO'=>$_POST['NOMBRE_USUARIO']??'',
      'CONTRASENA'=>$_POST['CONTRASENA']??'',
      'TIPO_USUARIO'=>$_POST['TIPO_USUARIO']??'',
    ]);
    header("Location: list.php"); exit;
  }catch(Throwable $t){ $error=$t->getMessage(); }
}
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?><body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Editar Usuario</h2>
<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post">
  <label class="form-label">Nombre de usuario</label><input class="form-control mb-2" name="NOMBRE_USUARIO" value="<?=htmlspecialchars($item['NOMBRE_USUARIO']??'')?>" required>
  <label class="form-label">Contraseña</label><input class="form-control mb-2" type="password" name="CONTRASENA" value="">
  <label class="form-label">Tipo</label>
  <select class="form-select mb-3" name="TIPO_USUARIO" required>
    <?php $ct=$item['TIPO_USUARIO']??''; foreach($tipos as $t): ?><option value="<?=$t?>" <?=($ct===$t)?'selected':''?>><?=$t?></option><?php endforeach;?>
  </select>
  <button class="btn btn-success">Actualizar</button> <a class="btn btn-secondary" href="list.php">Cancelar</a>
</form></main></body></html>
