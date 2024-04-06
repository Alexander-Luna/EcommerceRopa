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
                        <label for="imagenes" class="col-form-label">Imágenes:</label>
                        <input type="file" class="form-control-file" id="imagenes" name="imagenes" accept=".jpg, .jpeg, .png" multiple>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Genero:</label>
                        <select class="form-control" id="id_genero" name="id_genero" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Tipo de Prenda:</label>
                        <select class="form-control" id="id_tipo_prenda" name="id_tipo_prenda" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Ocasión:</label>
                        <select class="form-control" id="id_ocasion" name="id_ocasion" required>
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