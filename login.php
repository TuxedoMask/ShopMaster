<?php
include_once ("DBFuncs.php");
include_once ("global.php");
session_start();


$username = $_POST["username"];
$password = $_POST["password"];
global $db;
$id = $db->userLogin($username, $password);
if ($id == 1)
{
	$_SESSION['userID'] = $id;
	header ("Location: OwnerTools.php");
	exit;
}
elseif ($id > 1)
{
	$_SESSION['userID'] = $id;
	header ("Location: index.php");
	exit;
}
?>



<?php
	echo("Invalid login");
	include("login.html");

?>