<?php

class CRUD {
    private $conn;
    private $table;

    public function __construct($db, $table) {
        $this->conn = $db;
        $this->table = $table;
    }

    // Create (Agregar un nuevo registro)
    public function create($data) {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($query);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", htmlspecialchars(strip_tags($value)));
            }

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo "Error al crear el registro: " . $e->getMessage();
            return false;
        }
    }

    // Read (Obtener todos los registros)
    public function read() {
        try {
            $query = "SELECT * FROM {$this->table}";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al leer los registros: " . $e->getMessage();
            return [];
        }
    }

    // ReadOne (Obtener un solo registro basado en el id)
    public function readOne($id) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            // Si se encontró un registro, devolverlo
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return null; // Si no se encuentra el registro
            }
        } catch (PDOException $e) {
            echo "Error al leer el registro: " . $e->getMessage();
            return false;
        }
    }

    // Update (Actualizar un registro)
    public function update($id, $data) {
        try {
            $columns = "";
            foreach ($data as $key => $value) {
                $columns .= "$key = :$key, ";
            }
            $columns = rtrim($columns, ", ");
            $query = "UPDATE {$this->table} SET $columns WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", htmlspecialchars(strip_tags($value)));
            }
            $stmt->bindValue(":id", $id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo "Error al actualizar el registro: " . $e->getMessage();
            return false;
        }
    }

    // Delete (Eliminar un registro)
    public function delete($id) {
        try {
            $query = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":id", $id);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo "Error al eliminar el registro: " . $e->getMessage();
            return false;
        }
    }
}

?>
