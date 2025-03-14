<?php
require_once 'conexion.php';
require_once 'dao/VehiculoDAO.php';

$vehiculoDAO = new VehiculoDAO($pdo);

// Eliminar un vehículo si se envía el ID
if (isset($_GET['eliminar'])) {
    $id_vehiculo = $_GET['eliminar'];
    if ($vehiculoDAO->eliminarVehiculo($id_vehiculo)) {
        header("Location: consultar_vehiculos.php");
        exit;
    } else {
        echo "<script>alert('Error al eliminar el vehículo');</script>";
    }
}

// Obtener todos los vehículos
$vehiculos = $vehiculoDAO->obtenerVehiculos();

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Consultar Vehículos</h2>

    <!-- Tabla para mostrar los vehículos -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Placa</th>
                <th>VIN</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Kilometraje</th>
                <th>Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vehiculos)): ?>
                <?php foreach ($vehiculos as $vehiculo): ?>
                    <tr>
                        <td><?= htmlspecialchars($vehiculo['placa']) ?></td>
                        <td><?= htmlspecialchars($vehiculo['vin']) ?></td>
                        <td><?= htmlspecialchars($vehiculo['marca']) ?></td>
                        <td><?= htmlspecialchars($vehiculo['modelo']) ?></td>
                        <td><?= htmlspecialchars($vehiculo['año']) ?></td>
                        <td><?= htmlspecialchars($vehiculo['kilometraje_actual']) ?></td>
                        <td><?= htmlspecialchars($vehiculo['nombre_cliente'] . ' ' . $vehiculo['apellido_cliente']) ?></td>
                        <td>
                            <a href="editar_vehiculo.php?id=<?= $vehiculo['id_vehiculo'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="?eliminar=<?= $vehiculo['id_vehiculo'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este vehículo?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No hay vehículos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include 'includes/footer.php';
?>