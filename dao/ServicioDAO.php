<?php
require_once __DIR__ . '/../conexion.php';

class ServicioDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todos los servicios
    public function obtenerServicios() {
        try {
            $sql = "SELECT * FROM servicios";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerServicios: " . $e->getMessage());
        }
    }

    // Obtener el costo base de un servicio específico
    public function obtenerCostoServicio($id_servicio) {
        try {
            $sql = "SELECT costo_base FROM servicios WHERE id_servicio = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_servicio]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['costo_base'] : 0;
        } catch (PDOException $e) {
            die("Error en obtenerCostoServicio: " . $e->getMessage());
        }
    }
}
?>