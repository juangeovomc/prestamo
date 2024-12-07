<?php
require_once 'config\database.php';
require_once 'models\crud.php';

// Crear conexión y CRUD
$database = new Database();
$db = $database->getConnection();
$crud = new CRUD($db, 'prestamos');

// Procesar el formulario cuando se envía
if ($_POST) {
    // Recoger los datos del formulario
    $data = [
        'equipo' => $_POST['equipo'],
        'solicitante' => $_POST['solicitante'],
        'fecha_prestamo' => $_POST['fecha_prestamo'],
        'fecha_devolucion_prevista' => $_POST['fecha_devolucion_prevista'],
        'estado' => $_POST['estado'],
        'deposito_garantia' => $_POST['deposito_garantia']
    ];

    // Intentar insertar el nuevo préstamo
    if ($crud->create($data)) {
        header("Location: index.php?msg=added");
        exit();
    } else {
        $error_message = "Error al agregar el préstamo.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div class="container mt-5">
        <h1>Agregar Nuevo Préstamo</h1>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="equipo" class="form-label">Equipo</label>
                <input type="text" class="form-control" name="equipo" required>
            </div>
            <div class="mb-3">
                <label for="solicitante" class="form-label">Solicitante</label>
                <input type="text" class="form-control" name="solicitante" required>
            </div>
            <div class="mb-3">
                <label for="fecha_prestamo" class="form-label">Fecha Préstamo</label>
                <input type="date" class="form-control" name="fecha_prestamo" required>
            </div>
            <div class="mb-3">
                <label for="fecha_devolucion_prevista" class="form-label">Fecha Devolución Prevista</label>
                <input type="date" class="form-control" name="fecha_devolucion_prevista" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-control" name="estado" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Devuelto">Devuelto</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="deposito_garantia" class="form-label">Depósito Garantía</label>
                <input type="number" step="0.01" class="form-control" name="deposito_garantia" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
