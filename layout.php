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
		<a href="./index2.php"><img src='logo.png' align='center' width='100%'></a>
	</td>
	<td class='newHead' align='right' width='15%'>
<?php if(!isset($_SESSION['userID'])) { ?> 
		<a href="./index2.php?page=login">Log in</a></br>
          	<a href="./index2.php?page=create_account">Create an Account</a></li></br>
<?php }
	else {

		echo '<a href="logout.php">Logout</a></br>';
}

 ?>	      	

		<a href="./cart.php">Shopping Cart</a></br>

	</td>
	</tr>
</table>
</div>
  </body>
</html>