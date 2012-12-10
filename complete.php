<?php
/*
*	complete.php
*	File used for completing order and adding relevant information to the database
*	Unsets billing, shipping, and cart session variables
*/
	session_start();
	include_once ("DBFuncs.php");
	include_once ("global.php");
	include_once ("layout.php");

//Make sure user is logged in
if(!isset($_SESSION['userID']))
{
	echo("You must log in to be able to checkout");
}
else
{
	$shipInfo = $_SESSION['ship'];
	$billInfo = $_SESSION['bill'];
	unset($_SESSION['ship']);
	unset($_SESSION['bill']);
	$cart = $_SESSION['cart'];
	unset($_SESSION['cart']);
	$items = explode(',',$cart);
	$contents = array();
	//Store number of each item in cart using product ID as array key
	foreach ($items as $item) {
		$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
	}
	$count = 0;
	$cart = array();
	//Add each item to an array used to add items to the database
	foreach ($contents as $id=>$Quantity) {
		$row = $db->getOneProduct($id);
		$price = $row['UnitPrice'];
		$cart[$count] = $id;
		$count++;
		$cart[$count] = $price;
		$count++;
		$cart[$count] = $Quantity;
		$count++;
	}
	
	//Add order to the database
	$db->addOrder($_SESSION['userID'], $cart, $billInfo, $shipInfo);
	echo("<h1>Thank you for your order!</h1>");



}