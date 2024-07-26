<?php
$valorop = $_GET['opcion'];

switch ($valorop) {
    case 1:
        include("../view/registro_login.php");
        break;
    case 2:
        include("../view/miCuenta.php");
        break;
    case 3:
        include("../config/producto.php");
        break;
    default:
        echo "Opción no válida.";
        break;
}
?>
