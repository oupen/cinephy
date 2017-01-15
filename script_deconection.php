<?php
// Suppression des variables de session et de la session
session_start();
$_SESSION = $_SESSION['prénom'];
session_destroy();
// Suppression des cookies de connexion automatique
setcookie('login', '');
setcookie('pass_hache', '');
header('location:http://cinephy.com/login.php');
?>