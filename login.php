<?php
include_once ("DBFuncs.php");
include_once ("global.php");
session_start();


$username = $_POST["username"];
$password = $_POST["password"];
global $db;
$id = $db->userLogin($username, $password);
if ($id > 0)
{
	$_SESSION['userID'] = $id;
	header ("Location: index.php");
	exit;
}
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
	    
		<a href="./OwnerTools.php?page=login">Log in</a></br>
          	<a href="./OwnerTools.php?page=create_account">Create an Account</a></li></br>
	      	<a href="./OwnerTools.php?page=cart">Shopping Cart</a></br>
	    
	</td>
	</tr>
</table>
</div>
  <center>
  </body>
</html>


<?php
	echo("Invalid login");
	include("login.html");

?>