<?php
include("conexion.php");

class Controlador {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerProductos() {
        $sql = "SELECT * FROM producto";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        $productos = array();
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $productos[] = $row;
            }
        }
        return $productos;
    }

    public function obtenerProductosPorTipo($tipoProductoId) {
        $sql = "SELECT * FROM producto WHERE id_tipo_producto = $tipoProductoId";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        $productos = array();
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $productos[] = $row;
            }
        }
        return $productos;
    }

    public function obtenerNombreCategoria($idTipoProducto) {
        $sql = "SELECT nombre FROM tipo_producto WHERE id_tipo_producto = $idTipoProducto";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        $categoria = mysqli_fetch_assoc($result);
        return $categoria ? $categoria['nombre'] : '';
    }
}

$controlador = new Controlador($conn);

$tipoProductoId = isset($_GET['tipo']) ? intval($_GET['tipo']) : 8; // Por defecto mostrar Cerdo (id 8)
$productos = $controlador->obtenerProductosPorTipo($tipoProductoId);
$categoriaNombre = $controlador->obtenerNombreCategoria($tipoProductoId);
?>
