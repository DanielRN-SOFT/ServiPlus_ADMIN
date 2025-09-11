<?php
session_start();
$_SESSION['acceso'] = false;
session_destroy();
session_unset();
header("Location: ../views/login.php");
exit();
