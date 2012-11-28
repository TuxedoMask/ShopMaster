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
	    
		<a href="./OwnerTools.php?page=login">Log in</a></br>
          	<a href="./OwnerTools.php?page=create_account">Create an Account</a></li></br>
	      	<a href="./OwnerTools.php?page=cart">Shopping Cart</a></br>
	    
	</td>
	</tr>
</table>
</div>
   <h1> Owner's Tools </h1>

  </body>
</html>

<?php
#session_start();
// Get dbConn functions

//Read the following link to learn about testing this:
//http://userpages.umbc.edu/~jack/wwwtalk/html-notes.html

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
   
   if ($_GET['page'])
   {
      if ($_GET['page'] == 'login')
      {
         include("login.html");
      }
      elseif ($_GET['page'] == 'create_account')
      {
         include("createAccount.html");
      }
      elseif ($_GET['page'] == 'cart')
      {
         print "<p>Call to cart should go here</p><br>";
      }
      elseif ($_GET['page'] == 'addItem')
      {
         print "<p>Call to addItem should go here</p><br>";
         print '<br><a href="./OwnerTools.php?page=ownerTools">Return to Owner Tools Menu</a><br>';
      }
      elseif ($_GET['page'] == 'removeItem')
      {
         print "<p>Call to removeItem should go here</p><br>";
         print '<br><a href="./OwnerTools.php?page=ownerTools">Return to Owner Tools Menu</a><br>';
      }
      elseif ($_GET['page'] == 'editItem')
      {
         print "<p>Call to editItem should go here</p><br>";
         print '<br><a href="./OwnerTools.php?page=ownerTools">Return to Owner Tools Menu</a><br>';
      }
      elseif ($_GET['page'] == 'listOrders')
      {
         print "<p>Call to listOrders should go here</p><br>";
         print '<br><a href="./OwnerTools.php?page=ownerTools">Return to Owner Tools Menu</a><br>';
      }
      elseif ($_GET['page'] == 'ownerTools')
      {
         //To link to the main owner tools page, go to OwnerTools.php?page=ownerTools
         print '<a href="./OwnerTools.php?page=addItem">Add an Item</a><br>';
         print '<a href="./OwnerTools.php?page=removeItem">Remove an Item</a><br>';
         print '<a href="./OwnerTools.php?page=editItem">Edit an Item</a><br>';
         print '<a href="./OwnerTools.php?page=listOrders">List Orders</a><br>';
      }

   }
}



function addItem($item)
{

}

function removeItem($item)
{

}

function editItem($item)
{

}

function listOrders()
{

}

?>
