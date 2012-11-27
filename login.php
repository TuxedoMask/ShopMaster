
<?php 
session_start();
$_SESSION['dbConn'] = new dbFuncs();
$_SESSION['dbConn']->connect();

$username = $_POST["username"];
$password = $_POST["password"];

$_SESSION['dbConn']->userLogin($username, $password);


?>
