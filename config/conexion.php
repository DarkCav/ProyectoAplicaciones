<?php
// Procedimental
$servername = "sql10.freesqldatabase.com";
$username = "sql10721788";
$password = "QtihlLjnmA"; 
$database = "sql10721788";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

?>