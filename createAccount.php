<?php 

session_start();
include_once ("DBFuncs.php");
$dbConn = new DBFuncs();
$valid = false;
$email = $_POST["username"];
$password = $_POST["password"];
if(isValidEmail($email))
{
	$valid = true;
	$id = $dbConn->userSignup($email, $password);
	if ($id > 0)
	{
		$_SESSION['userID'] = $id;
		header ("Location: index.php");
		exit;
	}
	
}

	include_once ("layout.php");
	if($valid)
	{
		echo("E-mail address already registered.");
	}
	else echo ("Not a valid e-mail address.");
	include ("createAccount.html");

function isValidEmail($email){
    return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
}
?>