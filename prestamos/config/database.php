<?php

class Database {
    private $host = "localhost"; // Dirección del servidor de base de datos
    private $db_name = "prestamos"; // Nombre de la base de datos
    private $username = "root"; // Usuario de la base de datos
    private $password = ""; // Contraseña del usuario
    public $conn;

    // Método para obtener la conexión a la base de datos
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        } catch (PDOException $exception) {
            echo "Error al conectar a la base de datos: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>
