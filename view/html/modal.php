<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- Content Wrapper. Contains page content -->
            <div class="modal-header">
                <h5 class="modal-title" id="title">Detalles de la venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <section class="content">

                <div class="row">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="formularioVenta">
                            <input type="hidden" class="form-control" id="id_v" name="id_v" required>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="id_cliente" class="col-form-label">Cliente</label>
                                        <label class="form-control" id="cliente" name="cliente"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="recibe" class="col-form-label">Recibe:</label>
                                        <label class="form-control" id="recibe" name="recibe"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="telefono" class="col-form-label">Teléfono:</label>
                                        <label class="form-control" id="telefono" name="telefono"></label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fecha" class="col-form-label">Fecha</label>
                                        <label type="text" class="form-control" id="fecha" name="fecha"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="guia_serv" class="col-form-label"># Guía Servientrega:</label>
                                        <label type="text" class="form-control" id="guia_serv" name="guia_serv"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="est" class="col-form-label">Estado de Venta:</label>
                                        <label type="text" class="form-control" id="est" name="est"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="direccion" class="col-form-label">Dirección:</label>
                                <label class="form-control" id="direccion" name="direccion"></label>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label">Total Venta:</label>
                                    <label class="form-control" id="total_p" name="total_p">$0.00</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label">Costo de envió:</label>
                                    <label class="form-control" id="total_e" name="total_e">$0.00</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label">Comprobante</label>
                                    <button type="button" id="btnPdf" class="btn btn-danger form-control">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PNG</button>
                                </div>
                            </div>
                        </div>
                        <table id="miTablaM" class="datatable table table-bordered table-hover">

                        </table>
                        <script src="../html/content.js"></script>
                    </div>
                </div>
            </section>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-primary m-1" id="btnGuardar">Guardar</button> -->
            </div>
        </div>
    </div>
    <script>
        $('#miModal').on('hidden.bs.modal', function() {
            document.getElementById("cliente").textContent = "";
            document.getElementById("direccion").textContent ="";
            document.getElementById("recibe").textContent = "";
            document.getElementById("fecha").textContent = "";
            document.getElementById("telefono").textContent = "";
            document.getElementById("guia_serv").textContent = "";
            document.getElementById("est").textContent = "";
            document.getElementById("total_p").textContent = "";
            document.getElementById("total_e").textContent = "";
        });
        $('#exampleModal').on('shown.bs.modal', function() {
            $('#id_v').prop('disabled', false);
            $('#cliente').text('');
            $('#direccion').text('');
            $('#recibe').text('');
            $('#fecha').text('');
            $('#telefono').text('');
            $('#guia_serv').text('');
            $('#est').text('');
            $('#total_p').text('');
            $('#total_e').text('');
        });
    </script>
</div>