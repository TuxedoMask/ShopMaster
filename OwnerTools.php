<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <title>Wiki</title>
  </head>
  <img src="logo.png" alt="ShopMaster">
    <div id="sidebar">
      <h2>Navigation</h2>
      <div class="section">
        <ul>
          <li><a href="./OwnerTools.php?page=test">This is a php test</a></li>
        </ul>
      </div>
    </div>

  </body>
</html>

<?php
#session_start();
// Get dbConn functions

print "<p>HELLO</p>";

/*
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
   if ($_GET['page'])
   {
      if ($_GET['page'] == 'test')
      {
         print "<p>You clicked me</p>";
      }
   }
}
*/

class OwnerTools
{
    function addItem()
    {

    }

    function removeItem()
    {

    }

    function editItem()
    {

    }

    function listOrders()
    {

    }
}
?>
