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
    



    public function getVentaDetail()
    {
        $p_id = $_GET["id"];
        try {

            $conexion = parent::Conexion();
            $sql = "SELECT DISTINCT p.id,p.nombre, p.descripcion, i.precio_venta, i.stock 
                FROM inventario AS i
                INNER JOIN Ventaos AS p ON i.id_Ventao = p.id
                WHERE p.id = ?;";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }


    public function getAllVentas()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT * FROM ventas";
            $stmt = $conexion->prepare($sql);
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
}
