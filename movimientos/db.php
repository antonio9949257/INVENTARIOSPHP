<?php
$serv = "localhost";
$user = "root"; 
$pass = "2147"; 
$bd = "bdprueba";


$con = new mysqli($serv, $user, $pass, $bd);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>