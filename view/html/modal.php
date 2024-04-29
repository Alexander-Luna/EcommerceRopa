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
                            <input type="hidden" class="form-control" id="id" name="id" required>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="id_cliente" class="col-form-label">Cliente</label>
                                        <input type="hidden" class="form-control" id="id_cliente" name="id_cliente" required>
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
                                        <label for="direccion" class="col-form-label">Dirección:</label>
                                        <label class="form-control" id="direccion" name="direccion"></label>
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
                                        <select class="form-control" id="est" name="est" required>
                                            <option value="2">Enviada</option>
                                            <option value="1">Pagada</option>
                                            <option value="0">Pendiente</option>
                                        </select>
                                    </div>
                                </div>
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
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>
                                </div>
                            </div>
                        </div>
                        <table id="miTabla" class="datatable table table-bordered table-hover">

                        </table>
                        <script src="../html/content.js"></script>
                    </div>
                </div>
            </section>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary m-1" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>