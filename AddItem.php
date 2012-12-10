<?php
	session_start();
	include_once ("DBFuncs.php");
	include_once ("global.php");
	include_once ("layout.php");

// Get dbConn functions

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   print 'The item with the following parameters has been added to the inventory:<br><br>';
   print 'name = ' . $_POST['name'] . '<br>';
   print 'desc = ' . $_POST['desc'] . '<br>';
   print 'price = ' . $_POST['price'] . '<br>';
   print 'units = ' . $_POST['units'] . '<br>';
   print 'image = ' . $_POST['imageURL'] . '<br>';
   print 'featured = ' . $_POST['featured'] . '<br>';

   $item = array($_POST['name'], $_POST['desc'], $_POST['price'] ,$_POST['units'], $_POST['imageURL'],
                 $_POST['featured']);

   addItem($item);

   print '<br><a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';
}

//Add item to database. Need help with this one
function addItem($item)
{
   $db->addProduct($item);
}

include_once('footer.html');
?>
