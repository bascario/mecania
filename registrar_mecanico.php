<?php
require_once 'conexion.php';
require_once 'dao/MecanicoDAO.php';

$mecanicoDAO = new MecanicoDAO($pdo);

// Eliminar un mecánico si se envía el ID
if (isset($_GET['eliminar'])) {
    $id_mecanico = $_GET['eliminar'];
    if ($mecanicoDAO->eliminarMecanico($id_mecanico)) {
        header("Location: gestionar_mecanicos.php");
        exit;
    } else {
        echo "<script>alert('Error al eliminar el mecánico');</script>";
    }
}

// Obtener todos los mecánicos
$mecanicos = $mecanicoDAO->obtenerMecanicos();

// Registrar un nuevo mecánico
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'registrar') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad = $_POST['especialidad'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    if ($mecanicoDAO->registrarMecanico($nombre, $apellido, $especialidad, $telefono, $estado)) {
        header("Location: gestionar_mecanicos.php");
        exit;
    } else {
        echo "<script>alert('Error al registrar el mecánico');</script>";
    }
}

// Editar un mecánico existente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'editar') {
    $id_mecanico = $_POST['id_mecanico'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad = $_POST['especialidad'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    if ($mecanicoDAO->editarMecanico($id_mecanico, $nombre, $apellido, $especialidad, $telefono, $estado)) {
        header("Location: gestionar_mecanicos.php");
        exit;
    } else {
        echo "<script>alert('Error al editar el mecánico');</script>";
    }
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Gestión de Mecánicos</h2>

    <!-- Formulario para registrar un nuevo mecánico -->
    <h4 class="mt-4 mb-3">Registrar Mecánico</h4>
    <form method="POST" class="mb-4">
        <input type="hidden" name="accion" value="registrar">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="especialidad" class="form-label">Especialidad</label>
                    <input type="text" name="especialidad" id="especialidad" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-select" required>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

    <!-- Lista de mecánicos -->
    <h4 class="mt-4 mb-3">Lista de Mecánicos</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Especialidad</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($mecanicos)): ?>
                <?php foreach ($mecanicos as $mecanico): ?>
                    <tr>
                        <td><?= htmlspecialchars($mecanico['nombre']) ?></td>
                        <td><?= htmlspecialchars($mecanico['apellido']) ?></td>
                        <td><?= htmlspecialchars($mecanico['especialidad']) ?></td>
                        <td><?= htmlspecialchars($mecanico['telefono']) ?></td>
                        <td><?= htmlspecialchars($mecanico['estado']) ?></td>
                        <td>
                            <a href="?editar=<?= $mecanico['id_mecanico'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="?eliminar=<?= $mecanico['id_mecanico'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este mecánico?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay mecánicos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Formulario para editar un mecánico existente -->
    <?php if (isset($_GET['editar'])): ?>
        <?php
        $id_mecanico = $_GET['editar'];
        $mecanico = $mecanicoDAO->obtenerMecanicoPorId($id_mecanico);

        if (!$mecanico) {
            die("Error: Mecánico no encontrado.");
        }
        ?>
        <h4 class="mt-4 mb-3">Editar Mecánico</h4>
        <form method="POST" class="mb-4">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_mecanico" value="<?= $mecanico['id_mecanico'] ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre_editar" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre_editar" class="form-control" value="<?= htmlspecialchars($mecanico['nombre']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="apellido_editar" class="form-label">Apellido</label>
                        <input type="text" name="apellido" id="apellido_editar" class="form-control" value="<?= htmlspecialchars($mecanico['apellido']) ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="especialidad_editar" class="form-label">Especialidad</label>
                        <input type="text" name="especialidad" id="especialidad_editar" class="form-control" value="<?= htmlspecialchars($mecanico['especialidad']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telefono_editar" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono_editar" class="form-control" value="<?= htmlspecialchars($mecanico['telefono']) ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="estado_editar" class="form-label">Estado</label>
                        <select name="estado" id="estado_editar" class="form-select" required>
                            <option value="Activo" <?= $mecanico['estado'] === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $mecanico['estado'] === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
        <?php endif; ?>
</div>

<?php
include 'includes/footer.php';
?>