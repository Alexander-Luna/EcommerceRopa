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
    





    public function getAllVentas()
    {
        $page = 0;
        $nitems = 10;

        try {
            if (isset($_REQUEST['page'])) {
                $page = $_REQUEST['page'];
            }
            if (isset($_REQUEST['nitems'])) {
                $nitems = $_REQUEST['nitems'];
            }

            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos

            $sql = "SELECT i.*, p.*, c.nombre as color,catp.nombre as genero, t.descripcion,t.nombre as talla, img.img as imagen
            FROM inventario i
            INNER JOIN Ventaos p ON i.id_Ventao = p.id
            INNER JOIN categorias_Ventaos catp ON p.id_categoria = catp.id
            LEFT JOIN colores c ON i.id_color = c.id
            LEFT JOIN tallas t ON i.id_talla = t.id
            LEFT JOIN imagenes_Ventaos img ON img.id_Ventao = i.id_Ventao AND img.est = 1 AND img.principal = 1;
            ";

            // Añadir condiciones para LIMIT y OFFSET solo si los parámetros están presentes
            if (isset($_REQUEST['page']) && isset($_REQUEST['nitems'])) {
                $sql .= " LIMIT ? OFFSET ?";
            }

            $stmt = $conexion->prepare($sql);

            if (isset($_REQUEST['page']) && isset($_REQUEST['nitems'])) {
                $stmt->bindParam(1, $nitems, PDO::PARAM_INT);
                $stmt->bindParam(2, $page, PDO::PARAM_INT);
            }

            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getAllColores()
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "SELECT * FROM tallas";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
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

    public function getTallasProd()
    {
        $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
        $p_id = $_GET["id_prod"];
        try {
            $sql = "SELECT DISTINCT t.id AS id_talla, t.nombre AS talla 
            FROM inventario AS i
            INNER JOIN Ventaos AS p ON i.id_Ventao = p.id
            LEFT JOIN tallas AS t ON i.id_talla = t.id
            LEFT JOIN colores AS col ON i.id_color = col.id
            WHERE p.id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getImgProd()
    {
        $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
        $p_id = $_GET["id_prod"];
        try {
            $sql = "SELECT DISTINCT pf.img 
            FROM inventario AS i
            INNER JOIN imagenes_Ventaos AS pf ON i.id_Ventao = pf.id_Ventao
            WHERE i.id_Ventao = ? AND pf.est=1";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getWishList()
    {
        $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
        $p_id = $_GET["id_user"];
        try {
            $sql = "SELECT p.nombre,p.id,p.precio,p.existencia, COALESCE(pf.img, '') AS img
            FROM wish_list AS w
            INNER JOIN Ventaos AS p ON p.id = w.id_Ventao
            LEFT JOIN imagenes_Ventaos AS pf ON p.id = pf.id_Ventao AND pf.est = 1 AND pf.principal = 1
            WHERE w.id_usuario = ?;";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getColoresTalla()
    {
        try {
            $p_id = $_GET["id_prod"];
            $talla = $_GET["talla"];
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "SELECT col.id as id_color,col.nombre as color FROM inventario as i
            INNER JOIN Ventaos p ON i.id_Ventao = p.id
            INNER JOIN tallas t ON i.id_talla = t.id
            LEFT JOIN colores col ON i.id_color = col.id
            WHERE p.id = ? AND i.id_talla=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $p_id);
            $stmt->bindValue(2, $talla);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }



    public function getSliders()
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "SELECT * FROM sliders WHERE est=1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }
    // Otros métodos para insertar, actualizar, eliminar usuarios, etc.
}
