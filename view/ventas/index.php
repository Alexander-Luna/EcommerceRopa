<?php

$con = mysqli_connect($host, $user, $pass, $db);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Productos a Vender</h1>
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

                        <table id="tablaProductos" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID Producto</th>
                                    <th>ID Venta</th>
                                    <th>ID Cliente</th>
                                    <th>ID Pago</th>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Nombre</th>
                                    <th>Imagen</th>
                                    <th>Acción para liberar producto</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = "SELECT v.id AS idVenta, v.idCli, v.idPago, v.fecha, dv.idProd, dv.cantidad, dv.precio, dv.subTotal, p.nombre, f.web_path 
                                FROM ventas v
                                INNER JOIN detalleventas dv ON v.id = dv.idVenta
                                LEFT JOIN productos_files pf ON dv.idProd = pf.producto_id
                                LEFT JOIN files f ON pf.file_id = f.id
                                LEFT JOIN productos p ON dv.idProd = p.id";

                            $res = mysqli_query($con, $query);

                            while($row=mysqli_fetch_assoc($res) ){
                                ?>

                                <tr>
                                    <td><?php echo $row['idProd']; ?></td>
                                    <td><?php echo $row['idVenta']; ?></td>
                                    <td><?php echo $row['idCli']; ?></td>
                                    <td><?php echo $row['idPago']; ?></td>
                                    <td><?php echo $row['fecha']; ?></td>
                                    <td><?php echo $row['cantidad']; ?></td>
                                    <td>$<?php echo $row['precio']; ?></td>
                                    <td>$<?php echo $row['subTotal']; ?></td>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><img src="<?php echo $row['web_path']; ?>"  style="width: 50px; height: 50px;"></td>
                                    <td>
                                        <button class="btn btn-success">Activar</button>
                                        <button class="btn btn-danger">Desactivar</button>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <script src="content.js"></script>
</div>
