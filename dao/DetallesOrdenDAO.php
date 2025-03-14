<?php
require_once __DIR__ . '/../conexion.php';

class DetallesOrdenDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Registrar un detalle de orden
    public function registrarDetalle($id_orden, $id_servicio, $id_repuesto, $cantidad_repuestos, $horas_mano_obra, $subtotal) {
        try {
            $sql = "INSERT INTO detalles_orden (id_orden, id_servicio, id_repuesto, cantidad_repuestos, horas_mano_obra, subtotal) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id_orden, $id_servicio, $id_repuesto, $cantidad_repuestos, $horas_mano_obra, $subtotal]);
        } catch (PDOException $e) {
            die("Error en registrarDetalle: " . $e->getMessage());
        }
    }

    // Obtener los detalles de una orden específica
    public function obtenerDetallesPorOrden($id_orden) {
        try {
            $sql = "SELECT d.*, s.nombre_servicio, r.nombre_repuesto 
                    FROM detalles_orden d
                    LEFT JOIN servicios s ON d.id_servicio = s.id_servicio
                    LEFT JOIN repuestos r ON d.id_repuesto = r.id_repuesto
                    WHERE d.id_orden = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_orden]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerDetallesPorOrden: " . $e->getMessage());
        }
    }
}
?>