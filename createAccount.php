<?php include_once ("DBFuncs.php");
session_start();
include_once ("layout.php");
$dbConn = new DBFuncs();

$email = $_POST["username"];
$password = $_POST["password"];
if(isValidEmail($email))
{
	$valid = true;
	$id = $dbConn->userSignup($username, $password);
	if ($id > 0)
	{
		$_SESSION['userID'] = $id;
		header ("Location: OwnerTools.php");
		exit;
	}
	
}


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