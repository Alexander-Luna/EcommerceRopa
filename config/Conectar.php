<?php
/*TODO: Inicializando la sesión del usuario */
session_start();

/*TODO: Clase Conectar */
class Conectar
{
    protected $dbh;

    /*TODO: Función protegida para la conexión a la base de datos */
    protected function Conexion()
    {
        try {
            /*TODO: Cadena de conexión */
            $dsn = "mysql:host=localhost;dbname=ecommerce1;charset=utf8";
            //$this->dbh = new PDO($dsn, "dark", "12345");
            $this->dbh = new PDO($dsn, "root", "123456"); 
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->set_names();
            return $this->dbh;
        } catch (PDOException $e) {
            /*TODO: En caso de error en la conexión a la base de datos */
            die("¡Error BD!: " . $e->getMessage());
        }
    }

    /*TODO: Función para establecer el conjunto de caracteres de la conexión */
    public function set_names()
    {
        try {
            $this->dbh->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            /*TODO: Manejo de errores al establecer el conjunto de caracteres */
            die("¡Error al establecer el conjunto de caracteres!: " . $e->getMessage());
        }
    }
}
