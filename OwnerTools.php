<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <title>ShopMaster</title>
  </head>
  <img src="logo.png" alt="ShopMaster">

    <div id="sidebar">
      <div class="section">
        <ul>
          <li><a href="./OwnerTools.php?page=login">Log in</a></li>
          <li><a href="./OwnerTools.php?page=create_account">Create an Account</a></li>
        </ul>
      </div>
      <div id="sidebar2">
        <div class="section">
          <ul>
          <li><a href="./OwnerTools.php?page=cart">Shopping Cart</a></li>
        </ul>
      </div>
    </div>
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
         print "<p>Call to login should go here</p><br>";
      }
      elseif ($_GET['page'] == 'create_account')
      {
         print "<p>Call to create_account should go here</p><br>";
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
