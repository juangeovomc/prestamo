<?php
require_once 'config\database.php';
require_once 'models\crud.php';

// Verificar si se ha recibido el id del préstamo
if (isset($_GET['id'])) {
    // Obtener el id del préstamo
    $id = $_GET['id'];

    // Crear conexión y CRUD
    $database = new Database();
    $db = $database->getConnection();
    $crud = new CRUD($db, 'prestamos');

    // Intentar eliminar el registro
    if ($crud->delete($id)) {
        // Redirigir con mensaje de éxito
        header("Location: index.php?msg=deleted");
        exit();
    } else {
        // Redirigir con mensaje de error
        header("Location: index.php?msg=error");
        exit();
    }
} else {
    // Si no se recibe un id, redirigir al índice con mensaje de error
    header("Location: index.php?msg=error");
    exit();
}
?>
