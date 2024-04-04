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
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="col-form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imagen" class="col-form-label">Imagen:</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" required>
                    </div>
                    <div class="form-group">
                        <label for="talla" class="col-form-label">Talla:</label>
                        <input type="text" class="form-control" id="talla" name="talla" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo" class="col-form-label">Tipo:</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" required>
                    </div>
                    <div class="form-group">
                        <label for="color" class="col-form-label">Color:</label>
                        <input type="text" class="form-control" id="color" name="color" required>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="col-form-label">Stock:</label>
                        <input type="text" class="form-control" id="stock" name="stock" required>
                    </div>
                    <div class="form-group">
                        <label for="genero" class="col-form-label">Género:</label>
                        <input type="text" class="form-control" id="genero" name="genero" required>
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