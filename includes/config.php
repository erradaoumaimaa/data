<?php
session_start();
$con = new mysqli("localhost", "root", "", "db_dataware"); 
// Vérifiez la connexion
if ($con->connect_error) {
    die("La connexion à la base de données a échoué : " . $con->connect_error);
}
// echo "Connect Successfully. Host info: " . $mysqli->host_info;
//  UTF-8
mysqli_set_charset($con, "utf8");
?>
