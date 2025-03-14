<?php
require_once __DIR__ . '/../conexion.php';

class VehiculoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Registrar un nuevo vehículo
    public function registrarVehiculo($placa, $vin, $marca, $modelo, $anio, $kilometraje, $id_cliente) {
        try {
            $sql = "INSERT INTO vehiculos (placa, vin, marca, modelo, año, kilometraje_actual, id_cliente) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$placa, $vin, $marca, $modelo, $anio, $kilometraje, $id_cliente]);
        } catch (PDOException $e) {
            die("Error en registrarVehiculo: " . $e->getMessage());
        }
    }

    // Obtener todos los vehículos con datos del cliente
    public function obtenerVehiculos() {
        try {
            $sql = "SELECT v.*, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente 
                    FROM vehiculos v
                    JOIN clientes c ON v.id_cliente = c.id_cliente";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerVehiculos: " . $e->getMessage());
        }
    }

    // Obtener un vehículo específico por su ID
    public function obtenerVehiculoPorId($id_vehiculo) {
        try {
            $sql = "SELECT * FROM vehiculos WHERE id_vehiculo = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_vehiculo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en obtenerVehiculoPorId: " . $e->getMessage());
        }
    }

    // Editar un vehículo existente
    public function editarVehiculo($id_vehiculo, $placa, $vin, $marca, $modelo, $anio, $kilometraje, $id_cliente) {
        try {
            $sql = "UPDATE vehiculos 
                    SET placa = ?, vin = ?, marca = ?, modelo = ?, año = ?, kilometraje_actual = ?, id_cliente = ?
                    WHERE id_vehiculo = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$placa, $vin, $marca, $modelo, $anio, $kilometraje, $id_cliente, $id_vehiculo]);
        } catch (PDOException $e) {
            die("Error en editarVehiculo: " . $e->getMessage());
        }
    }

    // Eliminar un vehículo
    public function eliminarVehiculo($id_vehiculo) {
        try {
            $sql = "DELETE FROM vehiculos WHERE id_vehiculo = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id_vehiculo]);
        } catch (PDOException $e) {
            die("Error en eliminarVehiculo: " . $e->getMessage());
        }
    }
}
?>