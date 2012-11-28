<?php 
	include_once ("DBFuncs.php");
	session_start();
	header("Location: index2.php?page=featured");
	exit;
?>
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
	    
		<a href="./index.php?page=login">Log in</a></br>
          	<a href="./index.php?page=create_account">Create an Account</a></li></br>
	      	<a href="./index.php?page=cart">Shopping Cart</a></br>
	    
	</td>
	</tr>
</table>
</div>
  </body>
</html>
<?php
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
      else
      {
	  include("featured.php");
      }
   }
}
else include("featured.php");
?>