<?php
//variables con valores de conexión
$server = "localhost";
$user = "root";
$password = "";
$database = "proyecto_abd";

//Variable de conexión
$connect = mysqli_connect($server, $user, $password, $database);
if($connect->connect_error) {
	die("Failed to connect".$connect->connect_error);
} /*else {
	echo "You have successfully connected your database";
}*/

//Otra forma
/*$con = mysqli_connect("localhost", "root", "", "proyecto_abd");

if(!$con) {
	echo "Failed to connect";
} else {
	echo "You have successfully connected your database";
}*/
?>