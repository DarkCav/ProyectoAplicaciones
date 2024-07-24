<?php
session_start();
session_destroy();
header("Location: ../indexU.php");
exit();
?>