<?php
session_start();
include_once ("DBFuncs.php");
include_once ("global.php");
include_once ("layout.php");

// Get dbConn functions

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	print 'The item with the following parameters has been added to the inventory:<br><br>';
	print '<br>';
	print 'Product Name:<br>' . $_POST['name'] . '<br>';
	print '<br>';
	print 'Description:<br>' . $_POST['desc'] . '<br>';
	print '<br>';
	print 'Price:<br>$' . $_POST['price'] . '<br>';
	print '<br>';
	print 'Starting Stock:<br>' . $_POST['units'] . '<br>';
	print '<br>';
	print 'Image Link:<br>' . $_POST['imageURL'] . '<br>';
	print '<br>';
	print 'Featured Item:<br>';
	if ($_POST['featured'] == 1)
		print 'Yes' . '<br>';
	else
		print 'No' . '<br>';

	$item = array($_POST['name'], $_POST['desc'], $_POST['price'] ,$_POST['units'], $_POST['imageURL'], $_POST['featured']);

	addItem($item);
	print '<a href="./OwnerTools.php?page=addItem"><button>Add Another Item</button></a><br>';
	print '<br><a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';
}

//Add item to database. Need help with this one
function addItem($item)
{
	global $db;
	$db->addProduct($item);
}

include_once('footer.html');
?>
