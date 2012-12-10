<?php
	session_start();
	include_once ("DBFuncs.php");
	include_once ("global.php");
	include_once ("layout.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   print 'The item with the following parameters has been updated:<br><br>';

   print 'name = ' . $_POST['name'] . '<br>';
   print 'desc = ' . $_POST['desc'] . '<br>';
   print 'price = ' . $_POST['price'] . '<br>';
   print 'units = ' . $_POST['units'] . '<br>';
   print 'image = ' . $_POST['imageURL'] . '<br>';
   print 'featured = ' . $_POST['featured'] . '<br>';

   $item = array($_POST['name'], $_POST['desc'], $_POST['price'], $_POST['units'], $_POST['imageURL'],
                 $_POST['featured']);

   editItem($_POST['prodID'], $item);

   print '<br><a href="./OwnerTools.php?page=ownerTools"><button>Return to Owner Tools Menu</button></a><br>';
}

//Update the item in the database. Need help with this one
function editItem($prodID, $item)
{
   global $db;
   $db->updateProduct($prodID, $item);
}


include_once ('footer.html');
?>
