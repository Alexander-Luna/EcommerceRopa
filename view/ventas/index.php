

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ventas: Ropa que debes conocer </h1>
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
                    <?php require_once "../ventas/modal.php" ?>

                        <table id="miTabla" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Recibe</th>
                                    <th>Comprobante</th>
                                    <th>Método de Pago</th>
                                    <th>Pago</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llenará la tabla con los datos obtenidos de la base de datos -->
                            </tbody>
                        </table>
                        <script src="../ventas/content.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>