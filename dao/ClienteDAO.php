<?php
require_once __DIR__ . '/../conexion.php';

class ClienteDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Registrar un nuevo cliente
    public function registrarCliente($nombre, $apellido, $telefono, $email, $direccion) {
        try {
            $sql = "INSERT INTO clientes (nombre, apellido, telefono, email, direccion) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nombre, $apellido, $telefono, $email, $direccion]);
        } catch (PDOException $e) {
            die("Error en registrarCliente: " . $e->getMessage());
        }
    }

    // Obtener todos los clientes
    public function obtenerClientes() {
        try {
            $sql = "SELECT * FROM clientes";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerClientes: " . $e->getMessage());
        }
    }
}
?>