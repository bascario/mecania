<?php
require_once __DIR__ . '/../conexion.php';

class MecanicoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Registrar un nuevo mecánico
    public function registrarMecanico($nombre, $apellido, $especialidad, $telefono, $estado) {
        try {
            $sql = "INSERT INTO mecanicos (nombre, apellido, especialidad, telefono, estado) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nombre, $apellido, $especialidad, $telefono, $estado]);
        } catch (PDOException $e) {
            die("Error en registrarMecanico: " . $e->getMessage());
        }
    }

    // Obtener todos los mecánicos activos
    public function obtenerMecanicos() {
        try {
            $sql = "SELECT * FROM mecanicos";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerMecanicos: " . $e->getMessage());
        }
    }

    // Obtener un mecánico específico por su ID
    public function obtenerMecanicoPorId($id_mecanico) {
        try {
            $sql = "SELECT * FROM mecanicos WHERE id_mecanico = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_mecanico]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerMecanicoPorId: " . $e->getMessage());
        }
    }

    // Editar un mecánico existente
    public function editarMecanico($id_mecanico, $nombre, $apellido, $especialidad, $telefono, $estado) {
        try {
            $sql = "UPDATE mecanicos 
                    SET nombre = ?, apellido = ?, especialidad = ?, telefono = ?, estado = ?
                    WHERE id_mecanico = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nombre, $apellido, $especialidad, $telefono, $estado, $id_mecanico]);
        } catch (PDOException $e) {
            die("Error en editarMecanico: " . $e->getMessage());
        }
    }

    // Eliminar un mecánico
    public function eliminarMecanico($id_mecanico) {
        try {
            $sql = "DELETE FROM mecanicos WHERE id_mecanico = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id_mecanico]);
        } catch (PDOException $e) {
            die("Error en eliminarMecanico: " . $e->getMessage());
        }
    }
}
?>