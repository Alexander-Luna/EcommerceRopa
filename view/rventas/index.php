<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reporte de ventas</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="miformulario">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de Inicio:</label>
                                        <input type="date" class="form-control" id="fecha_ini" name="fecha_ini" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de Fin:</label>
                                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label">Buscar</label>
                                        <button type="submit" id="btnPagar" class="btn btn-primary form-control">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <label class="col-form-label">Descargar</label>

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label">Ventas Pendientes:</label>
                                    <label class="form-control" id="total_p" name="total_p">$0.00</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label">Ventas Entregadas:</label>
                                    <label class="form-control" id="total_e" name="total_e">$0.00</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label">Descargar</label>
                                    <button type="button" id="btnPdf" class="btn btn-danger form-control">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>
                                </div>
                            </div>
                        </div>
                        <table id="miTabla" class="datatable table table-bordered table-hover">

                        </table>
                        <script src="../rventas/content.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>