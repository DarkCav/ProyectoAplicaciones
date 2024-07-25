<?php
$valorop = $_GET['opcion'];

if ($valorop == 1) {
    include("../view/registro_login.php");
}
if ($valorop == 2) {
    include("../view/miCuenta.php");
}
?>