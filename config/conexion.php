<?php
// Procedimental
$servername = "localhost:3310";
$username = "root";
$password = "";
$database = "carniceria";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
echo "Conexión exitosa";

// Consultas y otras operaciones...

mysqli_close($conn);

// Orientado a Objetos
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";

?>
