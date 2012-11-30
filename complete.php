<?php
	session_start();
	include_once ("DBFuncs.php");
	include_once ("global.php");
	include_once ("layout.php");

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
	foreach ($items as $item) {
		$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
	}
	$count = 0;
	$cart = array();
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
	
	$db->addOrder($_SESSION['userID'], $cart, $billInfo, $shipInfo);
	echo("<h1>Thank you for your order!</h1>");



}