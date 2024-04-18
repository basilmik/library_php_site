<?php


$server="localhost";
$user="root";
$password="";
$db_name="library";
$reply="whatever@mail.ri";
$mysqli = mysqli_connect($server, $user, $password);

if (!$mysqli)
{
	echo "database not connected!";
}
	mysqli_select_db($mysqli, $db_name);

	mysqli_query($mysqli, "SET NAMES utf8");


?>