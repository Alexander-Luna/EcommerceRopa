<?php
require_once '../config/Conectar.php'; // Asegúrate de incluir la clase Conectar

class ProductModel extends Conectar
{
    public function getAllProducts()
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
            INNER JOIN productos p ON i.id_producto = p.id
            INNER JOIN categorias_productos catp ON p.id_categoria = catp.id
            LEFT JOIN colores c ON i.id_color = c.id
            LEFT JOIN tallas t ON i.id_talla = t.id
            LEFT JOIN imagenes_productos img ON img.id_producto = i.id_producto AND img.est = 1 AND img.principal = 1;
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

    public function getProductDetail()
    {
        $p_id = $_GET["id"];
        try {

            $conexion = parent::Conexion();
            $sql = "SELECT DISTINCT p.id,p.nombre, p.descripcion, i.precio_venta, i.stock 
                FROM inventario AS i
                INNER JOIN productos AS p ON i.id_producto = p.id
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
            INNER JOIN productos AS p ON i.id_producto = p.id
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
            INNER JOIN imagenes_productos AS pf ON i.id_producto = pf.id_producto
            WHERE i.id_producto = ? AND pf.est=1";
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
            INNER JOIN productos p ON i.id_producto = p.id
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
