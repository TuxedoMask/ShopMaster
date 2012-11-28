<?php include ("DBFuncs.php");
session_start();
$dbConn = new DBFuncs();

$email = $_POST["username"];
$password = $_POST["password"];
if(isValidEmail($email))
{
	$valid = true;
	$id = $dbConn->userSignup($username, $password);
	if ($id > 0)
	{
		$_SESSION['userID'] = $id;
		header ("Location: OwnerTools.php");
		exit;
	}
	
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
	if($valid)
	{
		echo("E-mail address already registered.");
	}
	else echo ("Not a valid e-mail address.");
	include ("createAccount.html");

function isValidEmail($email){
    return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
}
?>