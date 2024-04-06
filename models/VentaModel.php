<?php
require_once '../config/Conectar.php'; // Asegúrate de incluir la clase Conectar

class VentaModel extends Conectar
{
    public function getEstadisticas()
    {
        try {
            // Obtener la conexión usando parent::Conexion()
            $conexion = parent::Conexion();

            // Consulta para obtener el número de ventas de la última semana
            $queryNumVentas = "SELECT COUNT(id) AS num from ventas where fecha BETWEEN DATE( DATE_SUB(NOW(),INTERVAL 7 DAY) ) AND NOW();";
            $stmtNumVentas = $conexion->prepare($queryNumVentas);
            $stmtNumVentas->execute();
            $rowNumVentas = $stmtNumVentas->fetch(PDO::FETCH_ASSOC);

            // Consulta para obtener el número total de clientes
            $queryNumClientes = "SELECT COUNT(id) AS num from usuarios WHERE rol_id = 2;";
            $stmtNumClientes = $conexion->prepare($queryNumClientes);
            $stmtNumClientes->execute();
            $rowNumClientes = $stmtNumClientes->fetch(PDO::FETCH_ASSOC);

            // Consulta para obtener las ventas por día
            $queryVentasDia = "SELECT SUM(detalleventas.subtotal) as total, DATE(ventas.fecha) as fecha
                               FROM ventas
                               INNER JOIN detalleventas ON detalleventas.idventa = ventas.id
                               GROUP BY DATE(ventas.fecha);";
            $stmtVentasDia = $conexion->prepare($queryVentasDia);
            $stmtVentasDia->execute();
            $labelVentas = "";
            $datosVentas = "";

            while ($rowVentasDia = $stmtVentasDia->fetch(PDO::FETCH_ASSOC)) {
                $labelVentas .= "'" . $rowVentasDia['fecha'] . "',";
                $datosVentas .= $rowVentasDia['total'] . ",";
            }

            $labelVentas = rtrim($labelVentas, ",");
            $datosVentas = rtrim($datosVentas, ",");

            // Preparar los resultados para retornarlos
            $resultados = array(
                'numVentasSemana' => $rowNumVentas['num'],
                'numClientes' => $rowNumClientes['num'],
                'labelVentas' => $labelVentas,
                'datosVentas' => $datosVentas
            );

            return $resultados;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }






    public function getVentas()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT v.*, r.nombre AS nombre_recibe, r.telefono AS telefono_recibe, r.email AS email_recibe, r.direccion AS direccion_recibe,
            u.nombre AS nombre_usuario
FROM ventas v
INNER JOIN recibe r ON v.id_recibe = r.id
INNER JOIN usuarios u ON v.id_client = u.id;
;
        
        WHERE est_pago=0;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            die("Error al obtener ventas: " . $e->getMessage());
        }
    }
    public function getAllVentas()
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
        FROM ventas v
        INNER JOIN recibe r ON v.id_recibe = r.id
        INNER JOIN detalles_venta dv ON v.id = dv.id_venta
        INNER JOIN inventario inv ON dv.id_variante_producto = inv.id
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
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            die("Error al obtener ventas: " . $e->getMessage());
        }
    }

    public function  getDetalleVentas()
    {
        $id = $_GET['id'];
        // $id = 3;
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT 
            dv.id, 
            dv.id_venta, 
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
            detalles_venta dv
        JOIN 
            inventario i ON dv.id_variante_producto = i.id
        JOIN 
            colores c ON i.id_color = c.id
        JOIN 
            tallas t ON i.id_talla = t.id
        JOIN 
            productos p ON i.id_producto = p.id
        LEFT JOIN 
            imagenes_producto ip ON p.id = ip.id_producto AND ip.orden = 1 WHERE dv.id_venta=?;
        ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            die("Error al obtener ventas: " . $e->getMessage());
        }
    }

    public function updateVentas()
    {
        try {
            $id = $_POST["id"];
            $ruc = $_POST["ruc"];
            $nombre = $_POST["nombre"];
            $email = $_POST["email"];
            $telefono = $_POST["telefono"];
            $direccion = $_POST["direccion"];

            $conexion = parent::Conexion();
            $sql = "UPDATE ventas SET ruc=?, nombre=?, email=?, telefono=?, direccion=? WHERE id=?";
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

    public function deleteVentas()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();
            $sql = "UPDATE ventas SET est = CASE WHEN est = 1 THEN 0 ELSE 1 END WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido cambiar el estado del venta");
            }
        } catch (PDOException $e) {
            die("Error al cambiar el estado del venta: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function insertVentas()
    {
        try {
            $ruc = $_POST["ruc"];
            $nombre = $_POST["nombre"];
            $email = $_POST["email"];
            $telefono = $_POST["telefono"];
            $direccion = $_POST["direccion"];

            $conexion = parent::Conexion();
            $sql = "INSERT INTO ventas (ruc, nombre, email, telefono, direccion, est) VALUES (?, ?, ?, ?, ?, 1)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $ruc);
            $stmt->bindValue(2, $nombre);
            $stmt->bindValue(3, $email);
            $stmt->bindValue(4, $telefono);
            $stmt->bindValue(5, $direccion);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se ha podido insertar el registro");
            }
        } catch (PDOException $e) {
            die("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }


    public function getProductsCliente()
    {
        try {
            $est = $_GET['id'];
            $conexion = parent::Conexion();
            $sql = "SELECT v.*, r.nombre AS nombre_recibe, r.telefono AS telefono_recibe, r.email AS email_recibe, r.direccion AS direccion_recibe,
            u.nombre AS nombre_usuario,
            dv.cantidad, p.nombre AS nombre_producto, p.descripcion AS descripcion_producto, i.stock AS stock_producto,
            i.precio AS precio_producto, i.stock_alert AS stock_alert_producto,
            ip.url_imagen AS imagen_producto, v.est_pago AS estado_pago
FROM ventas v
INNER JOIN recibe r ON v.id_recibe = r.id
INNER JOIN usuarios u ON v.id_client = u.id
INNER JOIN detalles_venta dv ON v.id = dv.id_venta
INNER JOIN inventario i ON dv.id_variante_producto = i.id
INNER JOIN productos p ON i.id_producto = p.id
INNER JOIN imagenes_producto ip ON p.id = ip.id_producto
";

            if ($est != null) {
                $sql += " WHERE v.est_pago = ?;";
            }
            $stmt = $conexion->prepare($sql);
            if ($est != null) {
                $stmt->bindValue(1, $est);
            }

            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ventas;
        } catch (PDOException $e) {
            die("Error al obtener ventas: " . $e->getMessage());
        }
    }
}
