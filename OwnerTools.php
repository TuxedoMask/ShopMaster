<?php 
session_start();
include_once ("DBFuncs.php");
include_once ("global.php");
include_once ("layout.php");
global $db;
// Get dbConn functions

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$getarray = explode("?", $_GET['page']);
	$_GET['page'] = $getarray[0];
	$param = $getarray[1];

	if ($_GET['page'])
	{
		if ($_GET['page'] == 'addItem')
		{
			print "<p>Add an Item</p><br>";

			addItemGUI();

			print '<a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';
		}
		elseif ($_GET['page'] == 'removeItem')
		{
			print "<p>Select an Item to Remove</p><br>";

			listAllItems('remove');

			print '<a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';

		}
		elseif ($_GET['page'] == 'editItem')
		{
			print "<p>Select an Item to Edit</p><br>";

			listAllItems('edit');

			print '<a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';

		}
		elseif ($_GET['page'] == 'listOrders')
		{
			print "<p>Orders Received:</p><br>";

			listOrders();

			print '<a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';

		}
		elseif ($_GET['page'] == 'ownerTools')
		{
			//To link to the main owner tools page, go to OwnerTools.php?page=ownerTools
			print '<a href="./OwnerTools.php?page=addItem"><button>Add an Item</button></a><br>';
			print '<a href="./OwnerTools.php?page=removeItem"><button>Remove an Item</button></a><br>';
			print '<a href="./OwnerTools.php?page=editItem"><button>Edit an Item</button></a><br>';
			print '<a href="./OwnerTools.php?page=listOrders"><button>List Orders</button></a><br>';
		}
		elseif ($_GET['page'] == 'edit')
		{
			$pname = substr($param, 5);
			editItem($pname);
		}
		elseif ($_GET['page'] == 'remove')
		{
			$pname = substr($param, 5);
			removeItem($pname);
		}
		elseif ($_GET['page'] == 'displayOrder')
		{
			$orderID = substr($param, 6);
			displayOrder($orderID);
		}

	}
}
include_once('footer.html');

//The GUI for adding an item
function addItemGUI()
{
	//Name, desc., price, units, image, featured
	$name = 'Product Name: <input type="text" maxlength="40" name="name" style="width: 405px;" value="Product Name">';
	$desc = '<textarea name="desc" cols="60" maxlength="600" rows="20">Describe your product.</textarea>';
	$price = 'Price: <input type="text" name="price" value="0.00">';
	$units = 'Units: <input type="text" name="units" value="1" onkeypress="return isNumberKey(this);">';
	$image = 'Image URL: <input type="text" name="imageURL" style="width: 425px;" value="./images/noimage.png">';
	$featured = 'Featured?: <input type="text" maxlength="1" maxvalue="1" name="featured" value="0">';

	$formbegin = '<form action="AddItem.php" method="post">';
	$formend = '</form>';
	$submitbtn = '<button>Add This Item to Inventory</button>';

	print $formbegin;
	print $name . '<br>';
	print 'Description:' . '<br>' . $desc . '<br>';
	print $price . '<br>';
	print $units . '<br>';
	print $image . '<br>';
	print $featured . '<br>';

	print $submitbtn . $formend . '<br>';

}

//Lists all items in the form of clickable links
//$action is either 'remove' or 'edit'
function listAllItems($action)
{
	global $db;
	$items = $db->getAllProducts();
	while($item = mysql_fetch_array($items))
	{

		$ilink = '<a href="./OwnerTools.php?page=' . $action . '?item=' . $item['ProductID'] . '">' .
				'<button>' .  $item['ProductName'] . '</button>' . '</a><br>';
		print $ilink;
	}

	print '<br><br>';

}


//Remove an item message
function removeItem($prodID)
{
	print 'Product has been removed from the inventory.<br>';
	removeFromDatabase($prodID);
	print '<a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';
}

//Removes item from database. Need help with this one
function removeFromDatabase($prodID)
{
	global $db;
	$db->deleteProduct($prodID);
}

//Get item from database based on its productID, then bring up the Edit Item GUI
function editItem($prodID)
{
	global $db;
	$item = $db->getOneProduct($prodID);
	editItemGUI($item);
	print '<a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';
}


//GUI for editing an item
function editItemGUI($item)
{
	$name = 'Product Name: <input type="text" maxlength="40" name="name" style="width: 405px;" value="' . $item['ProductName'] . '">';
	$desc = '<textarea name="desc" cols="60" maxlength="600" rows="20">' . $item['ProductDesc']. '</textarea>';
	$price = 'Price: <input type="text" name="price" value="' . $item['UnitPrice'] . '">';
	$units = 'Units: <input type="text" name="units" onkeypress="return isNumberKey(this);" value="' . $item['UnitsInStock'] . '">';
	$image = 'Image URL: <input type="text" name="imageURL" style="width: 425px;" value="' . $item['Image'] . '">';
	$featured = 'Featured?: <input type="text" maxlength="1" maxvalue="1" name="featured" value="' . $item['Featured'] . '">';

	$formbegin = '<form action="EditItem.php" method="post">';
	$formend = '</form>';
	$submitbtn = '<button>Submit Changes</button>';

	print $formbegin;
	print $name . '<br>';
	print 'Description:' . '<br>' . $desc . '<br>';
	print $price . '<br>';
	print $units . '<br>';
	print $image . '<br>';
	print $featured . '<br>';
	print '<input type="hidden" value="'.$item['ProductID'].'" name="prodID">';
	print $submitbtn . $formend . '<br>';
}

//Lists all orders
function listOrders()
{
	global $db;
	$orders = $db->getOrders();
	while($order = mysql_fetch_array($orders))
	{
		printOrder($order);
	}
	print '<br><br>';
}

//Display order ID, customer ID, and date
//Order ID be a clickable link that takes admin to a page that contains the order details.
function printOrder($order)
{
	$orderID = $order['OrderID'];
	$customerID = $order['CustomerID'];
	$orderDate = $order['OrderDate'];
	$link = '<a href="./OwnerTools.php?page=displayOrder?order=' . $orderID . '"><button>' . 'Order ID: ' . $orderID . ' Customer ID: ' . $customerID . ' Order Date: ' . $orderDate . '</button></a><br>';
	print $link . '<br>';
}

//Print out an individual order
function displayOrder($orderID)
{
	$found = false;
	global $db;
	$orders = $db->getOrders();
	
	print 'OrderID = ' . $orderID . '<br>';
	
	while ($order = mysql_fetch_array($orders) && ($found == false))
	{
		if ($order['OrderID'] == $orderID)
		{
			$found = true;
		}
	}
	
	if ($found == true)
	{
	   //Order Number CustomerID OrderDate ShipName ShipEmail ShipPhone ShipAddress ShipCity ShipState ShipCountry ShipPostalCode
	   print 'Order Number ' . $orderID . ':<br>';
	   print 'Customer ID: ' . $order['CustomerID'] . '<br>';
	   print 'Order Date: ' . $order['OrderDate'] . '<br>';
	   print 'Ship Name: ' . $order['ShipName'] . '<br>';
	   print 'Ship Email: ' . $order['ShipEmail'] . '<br>';
	   print 'Ship Phone: ' . $order['ShipPhone'] . '<br>';
	   print 'Ship Address: ' . $order['ShipAddress'] . '<br>';
	   print 'Ship City: ' . $order['ShipCity'] . '<br>';
	   print 'Ship State: ' . $order['ShipState'] . '<br>';
	   print 'Ship Country: ' . $order['ShipCountry'] . '<br>';
	   print 'Ship Postal Code: ' . $order['ShipPostalCode'] . '<br>';
	}
	else
	{
		print 'Error: The order you requested was not found <br>';
	}
	
	print '<a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';
}

?>
