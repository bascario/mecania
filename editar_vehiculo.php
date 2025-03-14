<?php
require_once 'conexion.php';
require_once 'dao/VehiculoDAO.php';
require_once 'dao/ClienteDAO.php';

$vehiculoDAO = new VehiculoDAO($pdo);
$clienteDAO = new ClienteDAO($pdo);

$id_vehiculo = $_GET['id'] ?? null;

if (!$id_vehiculo) {
    die("Error: ID de vehículo no especificado.");
}

// Obtener el vehículo a editar
$vehiculo = $vehiculoDAO->obtenerVehiculoPorId($id_vehiculo);

if (!$vehiculo) {
    die("Error: Vehículo no encontrado.");
}

// Obtener clientes disponibles
$clientes = $clienteDAO->obtenerClientes();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placa = $_POST['placa'];
    $vin = $_POST['vin'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $kilometraje = $_POST['kilometraje'];
    $id_cliente = $_POST['id_cliente'];

    if ($vehiculoDAO->editarVehiculo($id_vehiculo, $placa, $vin, $marca, $modelo, $anio, $kilometraje, $id_cliente)) {
        header("Location: consultar_vehiculos.php");
        exit;
    } else {
        echo "<script>alert('Error al editar el vehículo');</script>";
    }
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Editar Vehículo</h2>

    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="placa" class="form-label">Placa</label>
                    <input type="text" name="placa" id="placa" class="form-control" value="<?= htmlspecialchars($vehiculo['placa']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vin" class="form-label">VIN</label>
                    <input type="text" name="vin" id="vin" class="form-control" value="<?= htmlspecialchars($vehiculo['vin']) ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" name="marca" id="marca" class="form-control" value="<?= htmlspecialchars($vehiculo['marca']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" name="modelo" id="modelo" class="form-control" value="<?= htmlspecialchars($vehiculo['modelo']) ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="anio" class="form-label">Año</label>
                    <input type="number" name="anio" id="anio" class="form-control" value="<?= htmlspecialchars($vehiculo['año']) ?>" min="1900" max="2099" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="kilometraje" class="form-label">Kilometraje Actual</label>
                    <input type="number" name="kilometraje" id="kilometraje" class="form-control" value="<?= htmlspecialchars($vehiculo['kilometraje_actual']) ?>" min="0" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="id_cliente" class="form-label">Cliente</label>
                    <select name="id_cliente" id="id_cliente" class="form-select" required>
                        <option value="">Seleccionar cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente['id_cliente'] ?>" <?= $cliente['id_cliente'] == $vehiculo['id_cliente'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<?php
include 'includes/footer.php';
?>