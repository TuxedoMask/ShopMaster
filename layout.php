<html>
	<head>
		<title>ShopMaster</title>
		<link rel="stylesheet" href="style.css" />
		
	</head>
	<body>
		<div id="wrapper">
	<div id="header">
				<a href="./index.php"><img src='logo.png' width="80%"></a>

				<ul>
<?php if(!isset($_SESSION['userID'])) { ?> 
					<li><a href="./index.php?page=create_account">Register</a></li>
					<li><a href="./index.php?page=login">Login</a></li>

<?php }
      else {
					echo '<li><a href="logout.php">Logout</a></li>';
	}				

?>					<li><a href="./cart.php">Cart</a></li>
				</ul>
	

	</div>
</body>
