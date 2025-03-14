<?php
require_once __DIR__ . '/../conexion.php';

class RepuestoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todos los repuestos
    public function obtenerRepuestos() {
        try {
            $sql = "SELECT * FROM repuestos";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerRepuestos: " . $e->getMessage());
        }
    }

    // Obtener el precio unitario de un repuesto específico
    public function obtenerPrecioRepuesto($id_repuesto) {
        try {
            $sql = "SELECT precio_unitario FROM repuestos WHERE id_repuesto = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_repuesto]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['precio_unitario'] : 0;
        } catch (PDOException $e) {
            die("Error en obtenerPrecioRepuesto: " . $e->getMessage());
        }
    }
}
?>