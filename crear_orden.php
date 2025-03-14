<?php
require_once 'conexion.php';
require_once 'dao/OrdenDAO.php';
require_once 'dao/VehiculoDAO.php';
require_once 'dao/MecanicoDAO.php';

$ordenDAO = new OrdenDAO($pdo);
$vehiculoDAO = new VehiculoDAO($pdo);
$mecanicoDAO = new MecanicoDAO($pdo);

// Obtener vehículos y mecánicos disponibles
$vehiculos = $vehiculoDAO->obtenerVehiculos();
$mecanicos = $mecanicoDAO->obtenerMecanicos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_vehiculo = $_POST['id_vehiculo'];
    $id_mecanico = $_POST['id_mecanico'];
    $fecha_inicio = $_POST['fecha_inicio'];

    if ($ordenDAO->crearOrden($id_vehiculo, $id_mecanico, $fecha_inicio)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Error al crear la orden');</script>";
    }
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Crear Orden de Trabajo</h2>

    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_vehiculo" class="form-label">Vehículo</label>
                    <select name="id_vehiculo" id="id_vehiculo" class="form-select" required>
                        <option value="">Seleccionar vehículo</option>
                        <?php foreach ($vehiculos as $vehiculo): ?>
                            <option value="<?= $vehiculo['id_vehiculo'] ?>">
                                <?= htmlspecialchars($vehiculo['placa'] . ' - ' . $vehiculo['marca'] . ' ' . $vehiculo['modelo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_mecanico" class="form-label">Mecánico</label>
                    <select name="id_mecanico" id="id_mecanico" class="form-select" required>
                        <option value="">Seleccionar mecánico</option>
                        <?php foreach ($mecanicos as $mecanico): ?>
                            <option value="<?= $mecanico['id_mecanico'] ?>">
                                <?= htmlspecialchars($mecanico['nombre'] . ' ' . $mecanico['apellido']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Crear Orden</button>
    </form>
</div>

<?php
include 'includes/footer.php';
?>