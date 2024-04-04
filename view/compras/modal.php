<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#miModal" data-whatever="@mdo">Nuevo</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Editar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioProducto">
                    <input type="hidden" class="form-control" id="id" name="id" required>
                    <div class="form-group">
                        <label class="col-form-label">Producto:</label>
                        <select class="form-control" id="id_producto" name="id_producto" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Cantidad para alerta:</label>
                        <input type="number" class="form-control" id="stock_alert" name="stock_alert" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Color:</label>
                        <select class="form-control" id="id_color" name="id_color" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Talla:</label>
                        <select class="form-control" id="id_talla" name="id_talla" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Proveedor:</label>
                        <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>