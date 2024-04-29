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
                        <label for="idPago" class="col-form-label">Cliente</label>
                        <input type="hidden" class="form-control" id="id_cliente" name="id_cliente" required>
                        <label class="form-control" id="cliente" name="cliente"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Recibe:</label>
                        <label class="form-control" id="recibe" name="recibe"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Teléfono:</label>
                        <label class="form-control" id="telefono" name="telefono"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Dirección:</label>
                        <label class="form-control" id="direccion" name="direccion"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Fecha</label>
                        <label type="text" class="form-control" id="fecha" name="fecha"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label"># Guía Servientrega:</label>
                        <input type="text" class="form-control" id="guia_serv" name="guia_serv">
                    </div>
                    <div class="form-group">
                        <label for="metodo_pago" class="col-form-label">Estado de Venta:</label>
                        <select class="form-control" id="est" name="est" required>
                            <option value="2">Enviada</option>
                            <option value="1">Pagada</option>
                            <option value="0">Pendiente</option>
                        </select>
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
        document.getElementById("id_cliente").value = "";
        document.getElementById("cliente").textContent = "";
        document.getElementById("recibe").textContent = "";
        document.getElementById("direccion").textContent = "";
        document.getElementById("telefono").textContent = "";
        document.getElementById("guia_serv").value = "";
        document.getElementById("est").value = "";
        document.getElementById("fecha").textContent = "";
    });
    $('#exampleModal').on('shown.bs.modal', function() {
        $('#id').prop('disabled', false);
        $('#id_cliente').val('');
        $('#est').val('');
        $('#guia_serv').val('');
        $('#cliente').text('');
        $('#recibe').text('');
        $('#direccion').text('');
        $('#telefono').text('');
        $('#fecha').val('');
    });
</script>