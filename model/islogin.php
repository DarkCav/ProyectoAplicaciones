<?php

session_start();
$usuario = $_SESSION['dev'];
$estado = false;
if (isset($usuario)){
    $estado = true;
}

?>