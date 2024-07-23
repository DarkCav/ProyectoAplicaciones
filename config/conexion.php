<?php
// Procedimental
$servername = "localhost";
$username = "root";
$password = "";
$database = "carniceria";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consultas y otras operaciones...

//mysqli_close($conn);

// Orientado a Objetos
/*$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}*/

?>
