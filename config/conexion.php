<?php
// Procedimental
$servername = "sql10.freesqldatabase.com";
$username = "sql10722097";
$password = "YV7WAYwTWJ"; 
$database = "sql10722097";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

?>