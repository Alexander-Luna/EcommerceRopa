<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#miModal" data-whatever="@mdo"><i class="fa fa-whatsapp nav-icon" aria-hidden="true"></i> Enviar Pre-Compra</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Realizar Pedidos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioUsuario">
                    <input type="hidden" id="id" name="id">

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
                <button type="button" class="btn btn-primary m-1" id="EnviarMensaje">Enviar Pedido</button>
            </div>
        </div>
    </div>
</div>
<script>
    fetch("../../controllers/router.php?op=getProveedores")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Hubo un problema al obtener los datos de género.");
            }
            return response.json();
        })
        .then((data) => {
            const selectGenero = document.getElementById("id_proveedor");
            selectGenero.innerHTML = "";
            data.forEach((proveedor) => {
                const option = document.createElement("option");
                option.value = proveedor.id;
                option.textContent = proveedor.nombre;
                selectGenero.appendChild(option);
            });
        });
</script>