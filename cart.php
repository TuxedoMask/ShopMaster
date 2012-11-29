<?php
// Include MySQL class
require_once('DBFuncs.php');
// Include database connection
require_once('global.php');

// Start the session
session_start();
// Process actions
$cart = $_SESSION['cart'];
$action = $_GET['action'];
switch ($action) {
	case 'add':
		
		$id = $_POST['id'];
		$row = $db->getOneProduct($id);
		$quantity = $_POST['quantity'];
		if ($quantity <= $row['UnitsInStock'])
		{
			if ($cart) {
				$cart .= ','.$id;
			} else {
				$cart = $id;
			}
			for($i = 1; $i < $quantity; $i++)
				$cart .= ','.$id;
		}
		else
		{
			$added = false;
		}
		break;
	case 'delete':
		if ($cart) {
			$items = explode(',',$cart);
			$newcart = '';
			foreach ($items as $item) {
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
		foreach ($_POST as $key=>$value) {
			if (stristr($key,'Quantity')) {
				$id = str_replace('Quantity','',$key);
				$items = ($newcart != '') ? explode(',',$newcart) : explode(',',$cart);
				$newcart = '';
				foreach ($items as $item) {
					if ($id != $item) {
						if ($newcart != '') {
							$newcart .= ','.$item;
						} else {
							$newcart = $item;
						}
					}
				}
				$row = $db->getOneProduct($id);
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
					} else {
						$newcart = $id;
					}
				}
				
			}
		}
	}
	$cart = $newcart;
	break;
}
$_SESSION['cart'] = $cart;
?>
<!DOCTYPE html>
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Cart</title>
	<link rel="stylesheet" href="style.css" />
</head>

<body>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <title>ShopMaster</title>
	  </head>
<div id='heading'>
<table>
	<tr>
	<td align='left' width='15%'>
	</td>
	<td align='center' width='70%'>
		<img src='logo.png' align='center' width='100%'>
	</td>
	<td class='newHead' align='right' width='15%'>
	    
		<a href="./index2.php?page=login">Log in</a></br>
          	<a href="./index2.php?page=create_account">Create an Account</a></li></br>
	      	<a href="./cart.php">Shopping Cart</a></br>
	    
	</td>
	</tr>
</table>
</div>
 
<div style="text-align:center;"> 
<div id="contents">

<h1>Please check quantities...</h1>

<?php
if(!$added)
{
	echo("Sorry, we only have " . $row['UnitsInStock'] . " " .$row['ProductName'] . " in stock.");
}

echo showCart();
?>

<p><a href="index2.php">Continue Shopping</a></p>
</div>
</div>

</body>
</html>
<?php
function writeShoppingCart() {
	$cart = $_SESSION['cart'];
	if (!$cart) {
		return '<p>You have no items in your shopping cart</p>';
	} else {
		// Parse the cart session variable
		$items = explode(',',$cart);
		$s = (count($items) > 1) ? 's':'';
		return '<p>You have <a href="cart.php">'.count($items).' item'.$s.' in your shopping cart</a></p>';
	}
}

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
			{extract($row);
			$output[] = '<tr>';
			$output[] = '<td><button type="submit" style="width:90%" formaction="cart.php?action=delete&id='.$id.'" class="r">Remove</button></td>';			$output[] = '<td>'.$ProductName.'</td>';
			$output[] = '<td>$'.$UnitPrice.'</td>';
			$output[] = '<td><input type="text" style="width:90%" name="Quantity'.$id.'" value="'.$Quantity.'" size="3" maxlength="3" /></td>';
			$output[] = '<td>$'.($UnitPrice * $Quantity).'</td>';
			$total += $UnitPrice * $Quantity;
			$output[] = '</tr>';
			}
		}
		$output[] = '</table>';
		$output[] = '<div style="width:85%;" align="right"><button type="submit">Update cart</button>' .
				'Grand total: $'.$total.'</div>';
		$output[] = '</table>';
		
		$output[] = '</form>';
	} else {
		$output[] = '<p>You shopping cart is empty.</p>';
	}
	return join('',$output);
}
?>
