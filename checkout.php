<?php
/*
*	checkout.php
*	File used for processing checkouts
*/
	session_start();
	include_once ("DBFuncs.php");
	include_once ("global.php");
	include_once ("layout.php");

//Make sure user is logged in before they can checkout	
if(!isset($_SESSION['userID']))
{
	echo("You must log in to be able to checkout");
}
else
{
	if($_GET['from'] == shipping)
	{
		//Gather shipping information from form and store into an array
		$shipping = array();
		$shipping['OrderDate'] = date("F j, Y");
		$shipping['ShipName'] = $_POST['fname'] . " " . $_POST['lname'];
		$shipping['ShipEmail'] = $_POST['e-mail'];
		$shipping['ShipPhone'] = $_POST['phone'];
		$shipping['ShipAddress'] = $_POST['address'];
		$shipping['ShipCity'] = $_POST['city'];
		$shipping['ShipCountry'] = $_POST['country'];
		$shipping['ShipState'] = $_POST['state'];
		$shipping['ShipPostalCode'] = $_POST['zip'];
		//Store information into session
		$_SESSION['ship'] = $shipping;
	}
	elseif($_GET['from'] == billing)
	{
		//Gather billing information from form and store into array
		$billing = array();
		$billing['LastName'] = $_POST['lname'];
		$billing['FirstName'] = $_POST['fname'];
		$billing['PhoneNo'] = $_POST['phone'];
		$billing['Address'] = $_POST['address'];
		$billing['City'] = $_POST['city'];
		$billing['Country'] = $_POST['country'];
		$billing['PostalCode'] = $_POST['zip'];
		//Store billing information into session
		$_SESSION['bill'] = $billing;
	}
	if ($_GET['action'] == shipping)
	{
		include("shipping.html");
	}
	elseif ($_GET['action'] == billing)
	{
		include("billing.html");
	}
	elseif ($_GET['action'] == complete)
	{
		include("complete.php");
	}
}
include_once ("footer.html");
?>
