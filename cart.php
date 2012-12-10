<?php
/*
*	cart.php
*	Processes cart actions, base code borrowed from http://v3.thewatchmakerproject.com/journal/276/
*	Modified to fit product needs
*/
// Start the session
session_start();
// Includes
include_once('DBFuncs.php');
include_once('global.php');
include_once('layout.php');

// Process actions
$cart = $_SESSION['cart'];
$action = $_GET['action'];
$added = true;
switch ($action) {
	case 'add':
		
		$id = $_POST['id'];
		$row = $db->getOneProduct($id);
		$quantity = $_POST['quantity'];
		//Check to make sure quantity is an int
		if(is_numeric($quantity))
		{
			$quantity = intval($quantity);
			if($quantity >= 0)
			{	
				$num = $quantity;
				//Get number of items with this product ID currently in cart
				if($cart)
				{
					$items = explode(',', $cart);
					$count = array_count_values($items);
					$num = $count[$id] + $quantity;
				}
				
				//Only add max number of units in stock
				if($row['UnitsInStock'] < $num) {
					$added = false;
					if($count)
					{
						$min = $row['UnitsInStock']-$count[$id];
					}
					else
					{
						$min = $row['UnitsInStock'];
					}	
				}
				else
				{	$added = true;
					$min = $quantity;
					//Check to see if cart exists and create if needed
					if ($cart) {
						$cart .= ','.$id;
					} else {
						$cart = $id;
					}
				}
				if (!$cart && $row['UnitsInStock'] > 0) {
					$cart = $id;
				}
				//add number of items desired to cart 
				for($i = 1; $i < $min; $i++)
					$cart .= ','.$id;
		
				
			}
		}
		//Non-numeric value entered into quantity field
		else
		{
			echo('<div style="color:red; text-align:center;">Invalid Quantity entered, item not added to cart</div>');
		}
		break;	
	case 'delete':
		if ($cart) {
			//convert cart string into an array
			$items = explode(',',$cart);
			$newcart = '';
			foreach ($items as $item) {
				//Compare against product id of item being deleted
				if ($_GET['id'] != $item) {
					if ($newcart != '') {
						$newcart .= ','.$item;
					} else {
						$newcart = $item;
					}
				}
			}
			$cart = $newcart;
		}
		break;
	case 'update':
	if ($cart) {
		$newcart = '';
		$badValue = false;
		//Each post is for a separate item in cart
		foreach ($_POST as $key=>$value) {
			//Check to make sure value is an integer
			if(is_numeric($value))
			{
				$value = intval($value);
				if (stristr($key,'Quantity')) {
					$id = str_replace('Quantity','',$key);
					$items = ($newcart != '') ? explode(',',$newcart) : explode(',',$cart);
					$newcart = '';
					//Step through entire cart
					foreach ($items as $item) {
						//Only add current product ID to cart
						if ($id != $item) {
							if ($newcart != '') {
								$newcart .= ','.$item;
							} else {
								$newcart = $item;
							}
						}
					}
					$row = $db->getOneProduct($id);
					//Only allow number of units in stock to be added to cart
					if($row['UnitsInStock'] < $value) {
						$added = false;
						$min = $row['UnitsInStock'];	
					}
					else
					{	$added = true;
						$min = $value;
					}
					for ($i=1;$i<=$min;$i++) {
						if ($newcart != '') {
							$newcart .= ','.$id;
						} 
						else {
							$newcart = $id;
						}
					}
				
				}
			}
			else
			{
				$badValue = true;
			}
		}
		//Error message if non-numeric value entered into one of the quantity fields
		if ($badValue)
			echo('<div style="color:red; text-align:center;">Invalid Quantity entered</div>');
	}
	$cart = $newcart;
	break;
}
//Store updated cart into session variable
$_SESSION['cart'] = $cart;
?>

 
<div id="contents">

<h1>Shopping Cart</h1>

<?php
if(!$added)
{
	echo("Sorry, we only have " . $row['UnitsInStock'] . " " .$row['ProductName'] . " in stock.");
}

echo showCart();


echo'<p><a href="index.php?page=home">Continue Shopping</a></p></div>';
include_once('footer.html');

//Function used to display cart contents to the user
//Shows Product name, unit price, quantity in cart, and total price
function showCart() {
	global $db;
	$cart = $_SESSION['cart'];
	if ($cart) {
		$items = explode(',',$cart);
		$contents = array();
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		}
		$output[] = '<form action="cart.php?action=update" method="post" id="cart">';
		$output[] = '<table class="center">';
		foreach ($contents as $id=>$Quantity) {
			
			$sql = 'SELECT * FROM Products WHERE ProductID = '.$id;
			$result = $db->execute($sql);
			if ( $row=mysql_fetch_array($result))
			{
				extract($row);
				$output[] = '<tr>';
				$output[] = '<td><button type="submit" formaction="cart.php?action=delete&id='.$id.'" class="r">Remove</button></td>';			
				$output[] = '<td><a href="items.php?prodID='.$row['ProductID'].'">'.$ProductName.'</td>';
				$output[] = '<td>$'.$UnitPrice.'</td>';
				$output[] = '<td><input type="text" name="Quantity'.$id.'" value="'.$Quantity.'" size="3" maxlength="3" onkeypress="return isNumberKey(this);"/></td>';
				$output[] = '<td>$'.($UnitPrice * $Quantity).'</td>';
				$total += $UnitPrice * $Quantity;
				$output[] = '</tr>';
			}
		}
		$output[] = '</table>';
		$output[] = '<div style="width:95%;" align="right"><button type="submit">Update cart</button>' .
				'<strong>Grand total: $'.$total.' </strong></div>';
		
		$output[] = '</form><form action="./checkout.php?action=shipping" method="post"><button type="submit">Checkout</button>';
	} else {
		$output[] = '<p>Your shopping cart is empty.</p>';
	}
	return join('',$output);
}
?>
