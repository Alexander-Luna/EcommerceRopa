<?php
require_once '../config/Conectar.php'; // Asegúrate de incluir la clase Conectar

class CompraModel extends Conectar
{
    public function getEstadisticas()
    {
        try {
            // Obtener la conexión usando parent::Conexion()
            $conexion = parent::Conexion();

            // Consulta para obtener el número de compras de la última semana
            $queryNumCompras = "SELECT COUNT(id) AS num from compras where fecha BETWEEN DATE( DATE_SUB(NOW(),INTERVAL 7 DAY) ) AND NOW();";
            $stmtNumCompras = $conexion->prepare($queryNumCompras);
            $stmtNumCompras->execute();
            $rowNumCompras = $stmtNumCompras->fetch(PDO::FETCH_ASSOC);

            // Consulta para obtener el número total de clientes
            $queryNumClientes = "SELECT COUNT(id) AS num from usuarios WHERE rol_id = 2;";
            $stmtNumClientes = $conexion->prepare($queryNumClientes);
            $stmtNumClientes->execute();
            $rowNumClientes = $stmtNumClientes->fetch(PDO::FETCH_ASSOC);

            // Consulta para obtener las compras por día
            $queryComprasDia = "SELECT SUM(detallecompras.subtotal) as total, DATE(compras.fecha) as fecha
                               FROM compras
                               INNER JOIN detallecompras ON detallecompras.idcompra = compras.id
                               GROUP BY DATE(compras.fecha);";
            $stmtComprasDia = $conexion->prepare($queryComprasDia);
            $stmtComprasDia->execute();
            $labelCompras = "";
            $datosCompras = "";

            while ($rowComprasDia = $stmtComprasDia->fetch(PDO::FETCH_ASSOC)) {
                $labelCompras .= "'" . $rowComprasDia['fecha'] . "',";
                $datosCompras .= $rowComprasDia['total'] . ",";
            }

            $labelCompras = rtrim($labelCompras, ",");
            $datosCompras = rtrim($datosCompras, ",");

            // Preparar los resultados para retornarlos
            $resultados = array(
                'numComprasSemana' => $rowNumCompras['num'],
                'numClientes' => $rowNumClientes['num'],
                'labelCompras' => $labelCompras,
                'datosCompras' => $datosCompras
            );

            return $resultados;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }






    public function getCompras()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT v.*, r.nombre AS nombre_recibe, r.telefono AS telefono_recibe, r.email AS email_recibe, r.direccion AS direccion_recibe,
            u.nombre AS nombre_usuario
FROM compras v
INNER JOIN recibe r ON v.id_recibe = r.id
INNER JOIN usuarios u ON v.id_client = u.id;
;
        
        WHERE est_pago=0;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $compras;
        } catch (PDOException $e) {
            die("Error al obtener compras: " . $e->getMessage());
        }
    }
    public function getAllCompras()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT v.id, v.fecha, v.total, r.nombre AS nombre_recibe, r.telefono AS telefono_recibe, r.email AS email_recibe, r.direccion AS direccion_recibe,
            u.nombre AS nombre_usuario,
            dv.id_variante_producto, dv.cantidad, dv.precio_unitario, dv.total_producto,
            p.nombre AS nombre_producto, p.descripcion AS descripcion_producto,
            g.nombre AS genero_producto, t.nombre AS tipo_prenda_producto,
            i.color, tll.talla, o.nombre AS ocasion_producto,
            ip.url_imagen AS imagen_producto
        FROM compras v
        INNER JOIN recibe r ON v.id_recibe = r.id
        INNER JOIN detalles_compra dv ON v.id = dv.id_compra
        INNER JOIN incomprario inv ON dv.id_variante_producto = inv.id
        INNER JOIN productos p ON inv.id_producto = p.id
        INNER JOIN genero g ON p.id_genero = g.id
        INNER JOIN tipo_prenda t ON p.id_tipo_prenda = t.id
        INNER JOIN colores i ON inv.id_color = i.id
        INNER JOIN tallas tll ON inv.id_talla = tll.id
        LEFT JOIN ocasion o ON p.id_ocasion = o.id
        LEFT JOIN imagenes_producto ip ON p.id = ip.id_producto AND ip.orden = 1
        INNER JOIN usuarios u ON v.id_client = u.id;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $compras;
        } catch (PDOException $e) {
            die("Error al obtener compras: " . $e->getMessage());
        }
    }

    public function  getDetalleCompras()
    {
        $id = $_GET['id'];
        // $id = 3;
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT 
            dv.id, 
            dv.id_compra, 
            dv.cantidad, 
            dv.precio_unitario, 
            dv.total_producto,
            p.nombre AS nombre_producto,
            ip.url_imagen AS imagen,
            i.id_color,
            i.id_talla,
            c.color,
            t.talla
        FROM 
            detalles_compra dv
        JOIN 
            incomprario i ON dv.id_variante_producto = i.id
        JOIN 
            colores c ON i.id_color = c.id
        JOIN 
            tallas t ON i.id_talla = t.id
        JOIN 
            productos p ON i.id_producto = p.id
        LEFT JOIN 
            imagenes_producto ip ON p.id = ip.id_producto AND ip.orden = 1 WHERE dv.id_compra=?;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $compras;
        } catch (PDOException $e) {
            die("Error al obtener compras: " . $e->getMessage());
        }
    }

    public function updateCompras()
    {
        try {
            $id = $_POST["id"];
            $ruc = $_POST["ruc"];
            $nombre = $_POST["nombre"];
            $email = $_POST["email"];
            $telefono = $_POST["telefono"];
            $direccion = $_POST["direccion"];

            $conexion = parent::Conexion();
            $sql = "UPDATE compras SET ruc=?, nombre=?, email=?, telefono=?, direccion=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $ruc);
            $stmt->bindValue(2, $nombre);
            $stmt->bindValue(3, $email);
            $stmt->bindValue(4, $telefono);
            $stmt->bindValue(5, $direccion);
            $stmt->bindValue(6, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido actualizar el registro");
            }
        } catch (PDOException $e) {
            die("Error al actualizar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function deleteCompras()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE compras SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido cambiar el estado del compra");
            }
        } catch (PDOException $e) {
            die("Error al cambiar el estado del compra: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function insertCompras()
    {
        try {
            $id_user = $_POST["id_user"]; // Asumiendo que tienes un campo en el formulario para el ID del usuario
            $total = $_POST["total"];
            $id_proveedor = $_POST["id_proveedor"];

            $conexion = parent::Conexion();
            $conexion->beginTransaction(); // Iniciar una transacción
            // Insertar datos en la tabla compras
            $sqlCompra = "INSERT INTO compras (id_user, total, id_proveedor) VALUES (?, ?, ?)";
            $stmtCompra = $conexion->prepare($sqlCompra);
            $stmtCompra->bindValue(1, $id_user);
            $stmtCompra->bindValue(2, $total);
            $stmtCompra->bindValue(3, $id_proveedor);
            $stmtCompra->execute();

            // Obtener el ID de la compra insertada
            $id_compra = $conexion->lastInsertId();

            // Insertar datos en la tabla detalles_compra
            $productos = $_POST["productos"]; // Asumiendo que tienes un array de productos desde el formulario
            foreach ($productos as $producto) {
                $id_variante_producto = $producto["id_variante_producto"];
                $cantidad = $producto["cantidad"];
                $precio_unitario = $producto["precio_unitario"];
                $total_producto = $producto["total_producto"];

                $sqlDetalleCompra = "INSERT INTO detalles_compra (id_compra, id_variante_producto, cantidad, precio_unitario, total_producto) VALUES (?, ?, ?, ?, ?)";
                $stmtDetalleCompra = $conexion->prepare($sqlDetalleCompra);
                $stmtDetalleCompra->bindValue(1, $id_compra);
                $stmtDetalleCompra->bindValue(2, $id_variante_producto);
                $stmtDetalleCompra->bindValue(3, $cantidad);
                $stmtDetalleCompra->bindValue(4, $precio_unitario);
                $stmtDetalleCompra->bindValue(5, $total_producto);
                $stmtDetalleCompra->execute();
            }

            // Confirmar la transacción
            $conexion->commit();

            return true; // Todo se ha realizado correctamente
        } catch (PDOException $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            die("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            $conexion->rollBack(); // Revertir la transacción en caso de error
            die("Error: " . $e->getMessage());
        }
    }
}
