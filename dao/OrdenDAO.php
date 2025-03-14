<?php
require_once __DIR__ . '/../conexion.php';

class OrdenDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Crear una nueva orden de trabajo
    public function crearOrden($id_vehiculo, $id_mecanico, $fecha_inicio) {
        try {
            $sql = "INSERT INTO ordenes_trabajo (id_vehiculo, id_mecanico, fecha_inicio, estado) 
                    VALUES (?, ?, ?, 'Pendiente')";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id_vehiculo, $id_mecanico, $fecha_inicio]);
        } catch (PDOException $e) {
            die("Error en crearOrden: " . $e->getMessage());
        }
    }

    // Cambiar el estado de una orden
    public function cambiarEstadoOrden($id_orden, $nuevo_estado) {
        try {
            $sql = "UPDATE ordenes_trabajo SET estado = ? WHERE id_orden = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nuevo_estado, $id_orden]);
        } catch (PDOException $e) {
            die("Error en cambiarEstadoOrden: " . $e->getMessage());
        }
    }

    // Obtener todas las órdenes de trabajo con detalles
    public function obtenerOrdenes() {
        try {
            $sql = "SELECT o.*, c.nombre AS cliente_nombre, c.apellido AS cliente_apellido, 
                           v.placa AS vehiculo_placa, v.marca AS vehiculo_marca, v.modelo AS vehiculo_modelo,
                           m.nombre AS mecanico_nombre, m.apellido AS mecanico_apellido
                    FROM ordenes_trabajo o
                    JOIN vehiculos v ON o.id_vehiculo = v.id_vehiculo
                    JOIN clientes c ON v.id_cliente = c.id_cliente
                    JOIN mecanicos m ON o.id_mecanico = m.id_mecanico";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerOrdenes: " . $e->getMessage());
        }
    }
}
?>