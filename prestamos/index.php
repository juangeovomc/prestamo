<?php
require_once 'config\database.php';
require_once 'models\crud.php';

// Crear conexión y CRUD
$database = new Database();
$db = $database->getConnection();
$crud = new CRUD($db, 'prestamos');

// Obtener todos los registros de la base de datos
$prestamos = $crud->read();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="container mt-5">
    <h1>Gestión de Préstamos</h1>

    <!-- Botón para agregar nuevo préstamo -->
    <a href="crear.php" class="btn btn-success mb-3">Agregar Nuevo Préstamo</a>

    <!-- Tabla de préstamos -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipo</th>
                <th>Solicitante</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th>Depósito Garantía</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestamos as $prestamo): ?>
                <tr>
                    <td><?= $prestamo['id'] ?></td>
                    <td><?= $prestamo['equipo'] ?></td>
                    <td><?= $prestamo['solicitante'] ?></td>
                    <td><?= $prestamo['fecha_prestamo'] ?></td>
                    <td><?= $prestamo['fecha_devolucion_prevista'] ?></td>
                    <td><?= $prestamo['estado'] ?></td>
                    <td><?= $prestamo['deposito_garantia'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $prestamo['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                        <button onclick="deleteRecord(<?= $prestamo['id'] ?>)" class="btn btn-danger btn-sm">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
    // Función para mostrar un mensaje de confirmación antes de eliminar
    function deleteRecord(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Este registro será eliminado permanentemente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'eliminar.php?id=' + id; // Redirige a la página de eliminación
            }
        });
    }

    // Mostrar mensajes de confirmación con SweetAlert2 basado en la URL
    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'added'): ?>
            Swal.fire('¡Éxito!', 'El préstamo ha sido agregado correctamente.', 'success');
        <?php elseif ($_GET['msg'] == 'updated'): ?>
            Swal.fire('¡Éxito!', 'El préstamo ha sido actualizado correctamente.', 'success');
        <?php elseif ($_GET['msg'] == 'deleted'): ?>
            Swal.fire('¡Éxito!', 'El préstamo ha sido eliminado.', 'success');
        <?php endif; ?>
    <?php endif; ?>
</script>

</body>
</html>
