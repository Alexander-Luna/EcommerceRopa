<button type="button" class="btn btn-primary mr-3" data-toggle="modal" data-target="#miModal" data-whatever="@mdo">Nueva Venta</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Nueva Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioVenta">
                    <input type="hidden" class="form-control" id="id" name="id" required>
                    <div class="form-group">
                        <label for="idcli" class="col-form-label">ID Cliente:</label>
                        <select class="form-control" id="idcli" name="idcli" required>
                            <!-- Aquí puedes agregar opciones para el campo ID Cliente -->
                            <option value="1">Cliente 1</option>
                            <option value="2">Cliente 2</option>
                            <option value="3">Cliente 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Número de Comprobante de Pago:</label>
                        <input type="text" class="form-control" id="idPago" name="idPago" required>
                    </div>
                    <div class="form-group">
                        <label for="metodo_pago" class="col-form-label">Método de Pago:</label>
                        <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                            <option value="1">Retiro en Oficina</option>
                            <option value="2">Subir Comprobante de Pago</option>
                        </select>
                    </div>
                 
                    <div class="form-group">
                        <label for="fecha" class="col-form-label">Fecha:</label>
                        <input type="text" class="form-control" id="fecha" name="fecha" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary m-1" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#miModal').on('hidden.bs.modal', function() {
        document.getElementById("id").value = "";
        document.getElementById("idcli").value = "";
        document.getElementById("idPago").value = "";
        document.getElementById("metodo_pago").value = "";
        document.getElementById("est").value = "";
        document.getElementById("fecha").value = "";
    });
    $('#exampleModal').on('shown.bs.modal', function() {
        // Activa el campo id
        $('#id').prop('disabled', false);
        // Limpia el valor del campo id
        $('#publicidad_id').val('');
        $('#idcli').val('');
        // Restablece el valor del campo idPago
        $('#idPago').val('');
        // Restablece el valor del campo metodo_pago
        $('#metodo_pago').val('');
        // Restablece el valor del campo est
        $('#est').val('');
        // Restablece el valor del campo fecha
        $('#fecha').val('');
    });
</script>