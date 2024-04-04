<?php
require_once '../config/Conectar.php';

class ProductModel extends Conectar
{
    public function getAllProducts()
    {
        try {
            $conexion = parent::Conexion();

            $sql = "SELECT o.nombre as ocasion,i.*, p.*, c.color, g.nombre as genero, t.desc_talla, t.talla, img.url_imagen as imagen
            FROM inventario i
            INNER JOIN productos p ON i.id_producto = p.id
            INNER JOIN genero g ON p.id_genero = g.id
            INNER JOIN ocasion o ON p.id_ocasion = o.id
            LEFT JOIN colores c ON i.id_color = c.id
            LEFT JOIN tallas t ON i.id_talla = t.id
            LEFT JOIN imagenes_producto img ON img.id_producto = i.id_producto AND img.est = 1 AND img.orden = 1";


            $stmt = $conexion->prepare($sql);


            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function getAllProductsAlert()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT prov.nombre AS prov_nombre, prov.*, i.*, p.*, c.color, g.nombre AS genero, t.desc_talla, t.talla, img.url_imagen AS imagen
            FROM inventario i
            INNER JOIN productos_proveedores pp ON i.id_producto = pp.id_producto
            INNER JOIN productos p ON pp.id_producto = p.id
            INNER JOIN genero g ON p.id_genero = g.id
            LEFT JOIN colores c ON i.id_color = c.id
            LEFT JOIN tallas t ON i.id_talla = t.id
            LEFT JOIN proveedores prov ON pp.id_proveedor = prov.id
            LEFT JOIN imagenes_producto img ON img.id_producto = i.id_producto AND img.est = 1 AND img.orden = 1
            WHERE i.stock_alert >= i.stock OR i.stock = 0;";
            $stmt = $conexion->prepare($sql);
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
            $conexion = parent::Conexion();
            $sql = "SELECT * FROM colores";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }
    public function getColores()
    {
        try {
            $conexion = parent::Conexion();
            $sql = "SELECT * FROM colores WHERE est=1";
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
            $sql = "SELECT p.id, p.nombre, p.descripcion, i.precio, i.stock 
                FROM inventario AS i
                INNER JOIN productos AS p ON i.id_producto = p.id
                WHERE p.id = ?";
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
        $conexion = parent::Conexion();
        $p_id = $_GET["id_prod"];
        try {
            $sql = "SELECT DISTINCT t.id AS id_talla, t.nombre AS talla 
                FROM inventario AS i
                INNER JOIN productos AS p ON i.id_producto = p.id
                LEFT JOIN Tallas AS t ON i.talla = t.nombre
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
        $conexion = parent::Conexion();
        $p_id = $_GET["id_prod"];
        try {
            $sql = "SELECT url_imagen 
                FROM imagenes_producto
                WHERE id_producto = ? AND est = 1";
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
        $conexion = parent::Conexion();
        $p_id = $_GET["id_user"];
        try {
            $sql = "SELECT p.nombre, p.id, p.precio, p.existencia, COALESCE(pf.url_imagen, '') AS img
                FROM Wish_List AS w
                INNER JOIN productos AS p ON p.id = w.id_producto
                LEFT JOIN imagenes_producto AS pf ON p.id = pf.id_producto AND pf.est = 1
                WHERE w.id_usuario = ?";
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
            $conexion = parent::Conexion();
            $sql = "SELECT col.id as id_color, col.nombre as color 
                FROM inventario as i
                INNER JOIN productos p ON i.id_producto = p.id
                INNER JOIN Tallas t ON i.talla = t.nombre
                LEFT JOIN Colores col ON i.id_color = col.id
                WHERE p.id = ? AND i.talla = ?";
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
}
