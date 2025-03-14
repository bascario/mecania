<?php
// Usar __DIR__ para obtener la ruta absoluta del directorio actual
require_once __DIR__ . '/../conexion.php';

class DashboardDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener el recuento de órdenes por estado
    public function obtenerRecuentoOrdenes() {
        try {
            $sql = "SELECT estado, COUNT(*) AS total FROM ordenes_trabajo GROUP BY estado";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerRecuentoOrdenes: " . $e->getMessage());
        }
    }

    // Obtener el total de ingresos diarios
    public function obtenerTotalIngresosDiarios($fecha) {
        try {
            $sql = "SELECT SUM(total_cobrado) AS total FROM ordenes_trabajo 
                    WHERE DATE(fecha_inicio) = ? AND estado = 'Completado'";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$fecha]);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (PDOException $e) {
            die("Error en obtenerTotalIngresosDiarios: " . $e->getMessage());
        }
    }

    // Obtener el total de ingresos generados por todas las órdenes completadas
    public function obtenerTotalIngresosGenerados() {
        try {
            $sql = "SELECT SUM(total_cobrado) AS total FROM ordenes_trabajo WHERE estado = 'Completado'";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (PDOException $e) {
            die("Error en obtenerTotalIngresosGenerados: " . $e->getMessage());
        }
    }

    // Obtener el total de vehículos registrados
    public function obtenerTotalVehiculos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM vehiculos";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            die("Error en obtenerTotalVehiculos: " . $e->getMessage());
        }
    }

    // Obtener el total de mecánicos activos
    public function obtenerTotalMecanicosActivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM mecanicos WHERE estado = 'Activo'";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            die("Error en obtenerTotalMecanicosActivos: " . $e->getMessage());
        }
    }
}
?>