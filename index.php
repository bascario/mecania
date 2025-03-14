<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';
require_once 'dao/DashboardDAO.php';

$dashboardDAO = new DashboardDAO($pdo);

// Obtener datos para el dashboard
$recuento_ordenes = $dashboardDAO->obtenerRecuentoOrdenes();
$total_ingresos_diarios = $dashboardDAO->obtenerTotalIngresosDiarios(date('Y-m-d'));
$total_ingresos_generados = $dashboardDAO->obtenerTotalIngresosGenerados();
$total_vehiculos = $dashboardDAO->obtenerTotalVehiculos();
$total_mecanicos_activos = $dashboardDAO->obtenerTotalMecanicosActivos();

// Procesar el recuento de órdenes
$ordenes_pendientes = 0;
$ordenes_en_proceso = 0;
$ordenes_completadas = 0;

foreach ($recuento_ordenes as $fila) {
    if ($fila['estado'] === 'Pendiente') {
        $ordenes_pendientes = $fila['total'];
    } elseif ($fila['estado'] === 'En Proceso') {
        $ordenes_en_proceso = $fila['total'];
    } elseif ($fila['estado'] === 'Completado') {
        $ordenes_completadas = $fila['total'];
    }
}

// Incluir el header común
include 'includes/header.php';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Dashboard</h1>

    <!-- Tarjetas de Resumen -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Órdenes Pendientes</h5>
                    <p class="card-text display-4"><?= $ordenes_pendientes ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Órdenes en Proceso</h5>
                    <p class="card-text display-4"><?= $ordenes_en_proceso ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Órdenes Completadas</h5>
                    <p class="card-text display-4"><?= $ordenes_completadas ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Ingresos Diarios</h5>
                    <p class="card-text display-4">$<?= number_format($total_ingresos_diarios, 2) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Componente de Cobros -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total de Ingresos Generados</h5>
                    <p class="card-text display-4 text-center">$<?= number_format($total_ingresos_generados, 2) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <a href="registrar_cobro.php" class="btn btn-dark w-100 h-100 d-flex align-items-center justify-content-center">
                Registrar Cobro
            </a>
        </div>
    </div>

    <!-- Estadísticas Adicionales -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Vehículos Registrados</h5>
                    <p class="card-text display-4 text-center"><?= $total_vehiculos ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mecánicos Activos</h5>
                    <p class="card-text display-4 text-center"><?= $total_mecanicos_activos ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlaces Directos -->
    <div class="row mt-5">
        <div class="col-md-4">
            <a href="registrar_cliente.php" class="btn btn-primary w-100 mb-3">Registrar Cliente</a>
        </div>
        <div class="col-md-4">
            <a href="registrar_vehiculo.php" class="btn btn-success w-100 mb-3">Registrar Vehículo</a>
        </div>
        <div class="col-md-4">
            <a href="registrar_mecanico.php" class="btn btn-secondary w-100 mb-3">Registrar Mecánico</a>
        </div>
        <div class="col-md-4">
            <a href="crear_orden.php" class="btn btn-warning w-100 mb-3">Crear Orden de Trabajo</a>
        </div>
        <div class="col-md-4">
            <a href="consultar_ordenes.php" class="btn btn-info w-100 mb-3">Consultar Órdenes</a>
        </div>
        <div class="col-md-4">
            <a href="reportes.php" class="btn btn-dark w-100 mb-3">Generar Reportes</a>
        </div>
    </div>
</div>

<?php
// Incluir el footer común
include 'includes/footer.php';
?>