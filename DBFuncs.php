<?php
class DBFuncs
{
	var $conn;

	//Constructor that connects to ShopMaster Database and stores the connection
	function DBFuncs()
	{
		$conn = mysql_connect("studentdb.gl.umbc.edu", "ply1", "ThereisnoP@ssw0rd")
		or die ("Could not connect to database" . mysql_error());
			
		$rs = mysql_select_db("ply1", $conn) or die ("Could not select database");

		$this->conn = $conn;
	}

	//Create a new user account on the database using the email and password provided
	//returns customer ID
	function userSignup($email, $pw)
	{
		$email = mysql_real_escape_string($email);
		$pw = mysql_real_escape_string($pw);
		$sql = "SELECT * FROM `ply1`.`Customers` WHERE `E-mail` = '".$email."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		//If num rows > 0, that e-mail is already registered
		if (mysql_num_rows($rs) > 0)
		{
			return 0;
		}
		//Add email and password to customer table
		$sql = "INSERT INTO `ply1`.`Customers` (`E-mail`, `Password`) VALUES ('".$email."', '".$pw."')";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		//Get and return user ID from database
		$sql = "SELECT `CustomerID` FROM `ply1`.`Customers` WHERE `E-mail` = '".$email."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_assoc($rs);
		return $row['CustomerID'];

	}

	//Allows a user to log in to ShopMaster
	//returns customer ID
	function userLogin($userName, $pw)
	{
		$userName = mysql_real_escape_string($userName);
		$sql = "SELECT `CustomerID`, `Password` FROM `ply1`.`Customers` WHERE `E-mail` = '".$userName."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		//Make sure passwords match
		if ($pw == $row[1])
		{

			return $row[0];
		}
		else return false;

	}

	//Add an order to the database
	//Items an array containing productId, UnitPrice, and Quantity for each item in that order
	function addOrder($custid, $items, $billInfo, $shipInfo)
	{
		$custid = mysql_real_escape_string($custid);
		//Add Shipping info to the orders table
		$sql = "INSERT INTO `ply1`.`Orders` (`CustomerID`, `OrderDate`, `ShipName`,
				`ShipEmail`, `ShipPhone`, `ShipAddress`, `ShipCity`, `ShipCountry`, `ShipPostalCode`, `ShipState`) VALUES
				(".$custid.", '$shipInfo[OrderDate]', '".mysql_real_escape_string($shipInfo[ShipName])."', '".mysql_real_escape_string($shipInfo[ShipEmail])."',
						'".mysql_real_escape_string($shipInfo[ShipPhone])."', '".mysql_real_escape_string($shipInfo[ShipAddress])."', '".mysql_real_escape_string($shipInfo[ShipCity])."',
								'".mysql_real_escape_string($shipInfo[ShipCountry])."', ".mysql_real_escape_string($shipInfo[ShipPostalCode]).", '".mysql_real_escape_string($shipInfo[ShipState])."')";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		//Get order Id from last query
		$orderID = mysql_insert_id();

		//Update billing information in the Customers table
		$sql = "UPDATE `ply1`.`Customers` SET `LastName` = '".mysql_real_escape_string($billInfo[LastName])."', `FirstName` = '".mysql_real_escape_string($billInfo[FirstName])."',
				`PhoneNo` = '".mysql_real_escape_string($billInfo[PhoneNo])."', `Address` = '".mysql_real_escape_string($billInfo[Address])."',
						`City` = '".mysql_real_escape_string($billInfo[City])."', `Country` = '".mysql_real_escape_string($billInfo[Country])."',
								`PostalCode` = '".mysql_real_escape_string($billInfo[PostalCode])."' WHERE `CustomerID` = '$custid'";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		//Add Order Details for each item in the array
		for($i = 0; $i < count($items); $i++)
		{
			$prodID = mysql_real_escape_string($items[$i]);
			$i++;
			$price = mysql_real_escape_string($items[$i]);
			$i++;
			$quant = mysql_real_escape_string($items[$i]);
			$sql = "INSERT INTO `ply1`.`Order Details` (`OrderID`, `ProductID`, `UnitPrice`, `Quantity`) VALUES ('".$orderID."','".$prodID."','".$price."','".$quant."')";
			$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				
			//Remove number of items ordered from the Units in Stock
			$quantity = $items[$i];
			$sql = "SELECT `UnitsInStock` FROM `ply1`.`Products` WHERE `ProductID` = '".$prodID."'";
			$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_array($rs);
			$newUnits = $row[UnitsInStock] - $quantity;
			$sql = "UPDATE `ply1`.`Products` SET `UnitsInStock` = '$newUnits' WHERE `ProductID` = '$prodID'";
			$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		}

	}
	//Get all products stored in the database
	//returns a resource, use mysql_fetch_array($rs) to get one row at a time
	function getAllProducts()
	{

		$sql = "SELECT `ProductID`,`ProductName`, `ProductDesc`, `UnitsInStock`, `Image`, `UnitPrice` FROM `ply1`.`Products`";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}
	//Get a single product from the database
	//Returns an array containing product information
	function getOneProduct($prodID)
	{
		mysql_real_escape_string($prodID);
		$sql = "SELECT `ProductID`, `ProductName`, `ProductDesc`, `UnitsInStock`, `Image`, `UnitPrice`, `Featured` FROM `ply1`.`Products` WHERE `ProductID` = ".$prodID."";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return mysql_fetch_array($rs);
	}
	//Add a product to the database
	function addProduct($productArr)
	{
		$name = mysql_real_escape_string($productArr[0]);
		$desc = mysql_real_escape_string($productArr[1]);
		$price = mysql_real_escape_string($productArr[2]);
		$units = mysql_real_escape_string($productArr[3]);
		$image = mysql_real_escape_string($productArr[4]);
		$featured = mysql_real_escape_string($productArr[5]);

		$sql = "INSERT INTO `ply1`.`Products` (`ProductName`, `ProductDesc`, `UnitPrice`, `UnitsInStock`, `Image`, `Featured`)
				VALUES ('".$name."', '".$desc."', '".$price."', '".$units."', '".$image."', '".$featured."')";

		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	}
	//Delete a product from the database
	function deleteProduct($prodID)
	{
		mysql_real_escape_string($prodID);
		$sql = "DELETE FROM `ply1`.`Products` WHERE `ProductID` = '$prodID'";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	}
	//Update a product in the database
	function updateProduct($prodID, $productArr)
	{
		$prodID = mysql_real_escape_string($prodID);
		$name = mysql_real_escape_string($productArr[0]);
		$desc = mysql_real_escape_string($productArr[1]);
		$price = mysql_real_escape_string($productArr[2]);
		$units = mysql_real_escape_string($productArr[3]);
		$image = mysql_real_escape_string($productArr[4]);
		$featured = mysql_real_escape_string($productArr[5]);
		$sql = "UPDATE `ply1`.`Products` SET `ProductName` = '$name', `ProductDesc` = '$desc',
				`UnitsInStock` = '$units', `Image` = '$image', `UnitPrice` = '$price', `Featured` = '$featured'
						WHERE `ProductID` = '$prodID'";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	}
	//Get all orders in the database
	//returns a mysql resource with all orders
	function getOrders()
	{
		$sql = "SELECT * FROM `ply1`.`Orders`";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}
	//Executes a sql query using the database connection
	function execute($sql)
	{
		return $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	}
	//Executes a sql query using the database connection
	function executeQuery($sql, $filename) // execute query
	{
		$rs = mysql_query($sql, $this->conn) or die("Could not execute query '$sql' in $filename " . mysql_error());
		return $rs;
	}
}