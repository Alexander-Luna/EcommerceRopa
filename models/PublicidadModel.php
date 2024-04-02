<?php
require_once '../config/Conectar.php'; // Asegúrate de incluir la clase Conectar

class PublicidadModel extends Conectar
{
    public function getAllSliders()
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "SELECT * FROM sliders";
            $stmt = $conexion->prepare($sql);
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

    public function updateSliders()
    {
        try {
            $id = $_POST["id"];
            $titulo = $_POST["titulo"];
            $descripcion = $_POST["descripcion"];

            // Actualizar los datos en la base de datos
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "UPDATE sliders SET titulo=?, descripcion=?, img=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $titulo);
            $stmt->bindValue(2, $descripcion);

            $rutaImagenes = '../public/images/sliders/';

            // Verificar si se ha cargado una nueva imagen
            if (!empty($_FILES["img"]["name"])) {
                // Nombre único de la imagen
                $nombreImagen = uniqid(); // Sin extensión para la conversión a WebP

                // Mover la nueva imagen a la carpeta deseada
                if (!move_uploaded_file($_FILES["img"]["tmp_name"], $rutaImagenes . $nombreImagen . '.webp')) {
                    throw new Exception("Error al mover la nueva imagen a la carpeta de destino");
                }

                // Obtener la imagen actual del registro
                $stmt_img = $conexion->prepare("SELECT img FROM sliders WHERE id=?");
                $stmt_img->execute([$id]);
                $imagenActual = $stmt_img->fetchColumn();

                // Eliminar la imagen actual si existe
                if ($imagenActual && file_exists($imagenActual)) {
                    unlink($imagenActual);
                }

                // Asignar la ruta de la nueva imagen en formato WebP al statement
                $stmt->bindValue(3, "../../public/images/sliders/" . $nombreImagen . '.webp');
            } else {
                // No se cargó una nueva imagen, mantener la imagen existente
                $stmt_img = $conexion->prepare("SELECT img FROM sliders WHERE id=?");
                $stmt_img->execute([$id]);
                $imagenActual = $stmt_img->fetchColumn();
                $stmt->bindValue(3, $imagenActual);
            }

            $stmt->bindValue(4, $id);

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se ha actualizado el registro correctamente
            if ($stmt->rowCount() > 0) {
                return true; // Se ha actualizado correctamente
            } else {
                throw new Exception("No se ha podido actualizar el registro");
            }
        } catch (PDOException $e) {
            die("Error al actualizar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function insertSliders()
    {
        try {
            // Obtener los datos enviados por el formulario
            $titulo = $_POST["titulo"];
            $descripcion = $_POST["descripcion"];

            // Insertar los datos en la base de datos
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "INSERT INTO sliders (titulo, descripcion, img, url_web) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $titulo);
            $stmt->bindValue(2, $descripcion);

            $rutaImagenes = '../public/images/sliders/';

            // Verificar si se ha cargado una nueva imagen
            if (!empty($_FILES["img"]["name"])) {
                // Nombre único de la imagen
                $nombreImagen = uniqid(); // Sin extensión para la conversión a WebP

                // Mover la imagen a la carpeta deseada
                if (!move_uploaded_file($_FILES["img"]["tmp_name"], $rutaImagenes . $nombreImagen . '.webp')) {
                    throw new Exception("Error al mover la imagen a la carpeta de destino");
                }

                // Asignar la ruta de la imagen en formato WebP al statement
                $stmt->bindValue(3, "../../public/images/sliders/" . $nombreImagen . '.webp');
            } else {
                $stmt->bindValue(3, ""); // No se cargó ninguna imagen
            }

            // Ruta de la imagen en formato WebP
            $stmt->bindValue(4, ""); // No se proporcionó la URL web
            $stmt->execute();

            // Verificar si se ha insertado el registro correctamente
            if ($stmt->rowCount() > 0) {
                return true; // Se ha insertado correctamente
            } else {
                throw new Exception("No se ha podido insertar el registro");
            }
        } catch (PDOException $e) {
            die("Error al insertar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }





    public function deleteSliders()
    {
        try {
            // Obtener el ID del registro a eliminar
            $id = $_POST["id"];

            // Obtener la ruta de la imagen para eliminarla del servidor
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "SELECT img FROM sliders WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();

            // Verificar si se ha encontrado el registro
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $imagenPath = $row['img'];

                // Eliminar la imagen del servidor
                if (unlink($imagenPath)) {
                    // Eliminar el registro de la base de datos
                    $sql = "DELETE FROM sliders WHERE id = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindValue(1, $id);
                    $stmt->execute();

                    // Verificar si se ha eliminado el registro correctamente
                    if ($stmt->rowCount() > 0) {
                        return true; // Se ha eliminado correctamente
                    } else {
                        throw new Exception("No se ha podido eliminar el registro de la base de datos");
                    }
                } else {
                    throw new Exception("Error al eliminar la imagen del servidor");
                }
            } else {
                throw new Exception("No se ha encontrado el registro en la base de datos");
            }
        } catch (PDOException $e) {
            die("Error al eliminar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // Otros métodos para insertar, actualizar, eliminar usuarios, etc.
}
