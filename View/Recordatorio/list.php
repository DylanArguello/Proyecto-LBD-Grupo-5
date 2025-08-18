<?php
// View/Recordatorio/list.php (sin SweetAlert2)
include_once __DIR__ . "/../../Controller/RecordatorioController.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$error=''; $items=[];
try { $items = $recordatorioModel->listar(); } catch (Throwable $t) { $error=$t->getMessage(); }
?>
<!DOCTYPE html><html lang="es"><?php PrintCss(); ?>
<body><?php PrintBarra(); ?>
<main class="container py-4"><h2>Recordatorios</h2>

<?php if(!empty($_SESSION['flash_success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?=htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']);?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if(!empty($_SESSION['flash_error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?=htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']);?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif;?>

<a class="btn btn-primary mb-3" href="create.php">Nuevo Recordatorio</a>

<table class="table table-bordered table-sm">
  <thead><tr><th>ID</th><th>Cita</th><th>Mensaje</th><th>Fecha envío</th><th>Acciones</th></tr></thead>
  <tbody>
  <?php foreach($items as $r): ?>
    <tr>
      <td><?=htmlspecialchars($r['ID_RECORDATORIO'])?></td>
      <td><?=htmlspecialchars($r['ID_CITA']??'')?></td>
      <td><?=htmlspecialchars($r['MENSAJE']??'')?></td>
      <td><?=htmlspecialchars($r['FECHA_ENVIO']??'')?></td>
      <td class="d-flex gap-1">
        <a class="btn btn-sm btn-warning" href="edit.php?id=<?=urlencode($r['ID_RECORDATORIO'])?>">Editar</a>
        <!-- Cancelación con Modal Bootstrap (sin SweetAlert2) -->
        <a class="btn btn-sm btn-danger"
        href="edit.php?id=<?=urlencode($r['ID_RECORDATORIO'])?>&cancel=1"
        onclick="return confirm('¿Seguro que deseas eliminar/cancelar este recordatorio? Esta acción no se puede deshacer.');">
        Eliminar
        </a>

      </td>
    </tr>
  <?php endforeach; if(!$items): ?>
    <tr><td colspan="5" class="text-center">Sin registros</td></tr>
  <?php endif; ?>
  </tbody>
</table>
</main>

<!-- Modal de confirmación (Bootstrap) -->
<div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirmar cancelación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p id="confirmCancelText" class="mb-0">¿Seguro que deseas cancelar este recordatorio? Esta acción no se puede deshacer.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
        <button id="btnConfirmCancel" class="btn btn-danger">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  let pendingHref = null;

  document.addEventListener('click', function(e){
    const btn = e.target.closest('[data-delete-link]');
    if (!btn) return;
    e.preventDefault();
    pendingHref = btn.getAttribute('href');

    const entidad = (btn.dataset.entity || 'registro').toLowerCase();
    const nombre  = btn.dataset.name || '';
    const txt = '¿Cancelar ' + entidad + (nombre ? ` “${nombre}”` : '') + '? Esta acción no se puede deshacer.';
    document.getElementById('confirmCancelText').textContent = txt;

    const modalEl = document.getElementById('confirmCancelModal');
    const modal   = new bootstrap.Modal(modalEl);
    modal.show();
  });

  document.getElementById('btnConfirmCancel').addEventListener('click', function(){
    if (pendingHref) window.location.href = pendingHref;
  });
})();
</script>
</body></html>

<?php PrintFooter(); ?>