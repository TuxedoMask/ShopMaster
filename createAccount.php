<?php 
/*
*	createAccount.php
*	File used for creating an account on the ShopMaster website
*/
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
		//set userID session
		$_SESSION['userID'] = $id;
		//Forward to homepage
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
//Display create account page again if invalid email
include ("createAccount.html");


//function used to check if e-mail address follows proper format, regEx found on StackOverflow
function isValidEmail($email){
    return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
}
?>