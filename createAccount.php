<html> 
<?php 
session_start();
$_SESSION['dbConn'] = new dbFuncs();
$db = $_SESSION['dbConn'];
$db->connect();

$username = $_POST["username"];
$password = $_POST["password"];

$_SESSION['dbConn']->userSignup($username, $password);


?>
</html>