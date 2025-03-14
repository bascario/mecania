<?php
require_once 'conexion.php';
require_once 'dao/DetallesOrdenDAO.php';
require_once 'dao/ServicioDAO.php';
require_once 'dao/RepuestoDAO.php';

$detallesOrdenDAO = new DetallesOrdenDAO($pdo);
$servicioDAO = new ServicioDAO($pdo);
$repuestoDAO = new RepuestoDAO($pdo);

$id_orden = $_GET['id'] ?? null;

if (!$id_orden) {
    die("Error: ID de orden no especificado.");
}

$servicios = $servicioDAO->obtenerServicios();
$repuestos = $repuestoDAO->obtenerRepuestos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_servicio = $_POST['id_servicio'];
    $id_repuesto = $_POST['id_repuesto'];
    $cantidad_repuestos = $_POST['cantidad_repuestos'];
    $horas_mano_obra = $_POST['horas_mano_obra'];

    $costo_servicio = $servicioDAO->obtenerCostoServicio($id_servicio);
    $precio_repuesto = $repuestoDAO->obtenerPrecioRepuesto($id_repuesto);
    $subtotal = ($costo_servicio * $horas_mano_obra) + ($precio_repuesto * $cantidad_repuestos);

    if ($detallesOrdenDAO->registrarDetalle($id_orden, $id_servicio, $id_repuesto, $cantidad_repuestos, $horas_mano_obra, $subtotal)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Error al registrar el detalle');</script>";
    }
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Registrar Cobro para la Orden <?= htmlspecialchars($id_orden) ?></h2>

    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_servicio" class="form-label">Servicio</label>
                    <select name="id_servicio" id="id_servicio" class="form-select" required>
                        <option value="">Seleccionar servicio</option>
                        <?php foreach ($servicios as $servicio): ?>
                            <option value="<?= $servicio['id_servicio'] ?>">
                                <?= htmlspecialchars($servicio['nombre_servicio']) ?> - $<?= number_format($servicio['costo_base'], 2) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_repuesto" class="form-label">Repuesto</label>
                    <select name="id_repuesto" id="id_repuesto" class="form-select">
                        <option value="">Seleccionar repuesto (opcional)</option>
                        <?php foreach ($repuestos as $repuesto): ?>
                            <option value="<?= $repuesto['id_repuesto'] ?>">
                                <?= htmlspecialchars($repuesto['nombre_repuesto']) ?> - $<?= number_format($repuesto['precio_unitario'], 2) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="cantidad_repuestos" class="form-label">Cantidad de Repuestos</label>
                    <input type="number" name="cantidad_repuestos" id="cantidad_repuestos" class="form-control" min="0" value="0">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="horas_mano_obra" class="form-label">Horas de Mano de Obra</label>
                    <input type="number" name="horas_mano_obra" id="horas_mano_obra" class="form-control" step="0.01" min="0" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Detalle</button>
    </form>
</div>

<?php
include 'includes/footer.php';
?>