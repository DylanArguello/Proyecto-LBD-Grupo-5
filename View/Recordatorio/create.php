<form method="POST" action="store.php">
    <div class="form-group">
        <label>ID Recordatorio</label>
        <input type="number" name="id" class="form-control" required>
    </div>
    <div class="form-group">
        <label>ID Cita</label>
        <input type="number" name="cita" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Mensaje</label>
        <input type="text" name="mensaje" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Fecha de Envío</label>
        <input type="date" name="fecha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
</form>
