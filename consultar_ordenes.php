<?php
require_once 'conexion.php';
require_once 'dao/OrdenDAO.php';

$ordenDAO = new OrdenDAO($pdo);

// Obtener todas las órdenes de trabajo
$ordenes = $ordenDAO->obtenerOrdenes();

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Consultar Órdenes de Trabajo</h2>

    <!-- Tabla para mostrar las órdenes -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Orden</th>
                <th>Cliente</th>
                <th>Vehículo (Placa)</th>
                <th>Mecánico</th>
                <th>Fecha Inicio</th>
                <th>Estado</th>
                <th>Total Cobrado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($ordenes)): ?>
                <?php foreach ($ordenes as $orden): ?>
                    <tr>
                        <td><?= htmlspecialchars($orden['id_orden']) ?></td>
                        <td><?= htmlspecialchars($orden['cliente_nombre'] . ' ' . $orden['cliente_apellido']) ?></td>
                        <td><?= htmlspecialchars($orden['vehiculo_placa'] . ' - ' . $orden['vehiculo_marca'] . ' ' . $orden['vehiculo_modelo']) ?></td>
                        <td><?= htmlspecialchars($orden['mecanico_nombre'] . ' ' . $orden['mecanico_apellido']) ?></td>
                        <td><?= htmlspecialchars($orden['fecha_inicio']) ?></td>
                        <td><?= htmlspecialchars($orden['estado']) ?></td>
                        <td>$<?= number_format($orden['total_cobrado'], 2) ?></td>
                        <td>
                            <a href="registrar_cobro.php?id=<?= $orden['id_orden'] ?>" class="btn btn-primary btn-sm">Registrar Cobro</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No hay órdenes registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include 'includes/footer.php';
?>