<?php
class DBFuncs
{
	var $conn;

	function DBFuncs()
	{
		$conn = mysql_connect("studentdb.gl.umbc.edu", "ply1", "ThereisnoP@ssw0rd")
			or die ("Could not connect to database" . mysql_error());
			
		$rs = mysql_select_db("ply1", $conn) or die ("Could not select database");
		
		$this->conn = $conn;
	}
	function getUserName($userID)
	{
		$userID = mysql_real_escape_string($userID);
		$sql = "SELECT `FirstName` FROM `ply1`.`Customers` WHERE `CustomerID` = '".$userID."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		return $row['FirstName'];
	}
	function userSignup($email, $pw)
	{
		$email = mysql_real_escape_string($email);
		$pw = mysql_real_escape_string($pw);
		$sql = "SELECT * FROM `ply1`.`Customers` WHERE `E-mail` = '".$email."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		if (mysql_num_rows($rs) > 0)
		{
			return 0;
		}
		$sql = "INSERT INTO `ply1`.`Customers` (`E-mail`, `Password`) VALUES ('".$email."', '".$pw."')";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		
		$sql = "SELECT `CustomerID` FROM `ply1`.`Customers` WHERE `E-mail` = '".$email."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_assoc($rs);
		return $row['CustomerID'];
		
	}	
	
	function userLogin($userName, $pw)
	{
		$userName = mysql_real_escape_string($userName);
		$sql = "SELECT `CustomerID`, `Password` FROM `ply1`.`Customers` WHERE `E-mail` = '".$userName."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		
		if ($pw == $row[1])
		{

			return $row[0];
		}
		else return false;
		
	}

	//Not Finished
	//Items a 2d array containing, productId - UnitPrice - Quantity
	function addOrder($custid, $items, $billInfo, $shipInfo)
	{	
		$custid = mysql_real_escape_string($custid);
		echo mysql_real_escape_string($shipInfo[ShipPhone]);
		$sql = "INSERT INTO `ply1`.`Orders` (`CustomerID`, `OrderDate`, `ShipName`, 
			`ShipEmail`, `ShipPhone`, `ShipAddress`, `ShipCity`, `ShipCountry`, `ShipPostalCode`, `ShipState`) VALUES 
			(".$custid.", '$shipInfo[OrderDate]', '".mysql_real_escape_string($shipInfo[ShipName])."', '".mysql_real_escape_string($shipInfo[ShipEmail])."', 
			'".mysql_real_escape_string($shipInfo[ShipPhone])."', '".mysql_real_escape_string($shipInfo[ShipAddress])."', '".mysql_real_escape_string($shipInfo[ShipCity])."',
			'".mysql_real_escape_string($shipInfo[ShipCountry])."', ".mysql_real_escape_string($shipInfo[ShipPostalCode]).", '".mysql_real_escape_string($shipInfo[ShipState])."')";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
		$orderID = mysql_insert_id();	

		$sql = "UPDATE `ply1`.`Customers` SET `LastName` = '".mysql_real_escape_string($billInfo[LastName])."', `FirstName` = '".mysql_real_escape_string($billInfo[FirstName])."',
			`PhoneNo` = '".mysql_real_escape_string($billInfo[PhoneNo])."', `Address` = '".mysql_real_escape_string($billInfo[Address])."',
			`City` = '".mysql_real_escape_string($billInfo[City])."', `Country` = '".mysql_real_escape_string($billInfo[Country])."', 
			`PostalCode` = '".mysql_real_escape_string($billInfo[PostalCode])."' WHERE `CustomerID` = '$custid'";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
		
		for($i = 0; $i < count($items); $i++)
		{
			$prodID = mysql_real_escape_string($items[$i]);
			$i++;
			$price = mysql_real_escape_string($items[$i]);
			$i++;
			$quant = mysql_real_escape_string($items[$i]);
			$sql = "INSERT INTO `ply1`.`Order Details` (`OrderID`, `ProductID`, `UnitPrice`, `Quantity`) VALUES ('".$orderID."','".$prodID."','".$price."','".$quant."')";
			$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			
			$quantity = $items[$i];
			$sql = "SELECT `UnitsInStock` FROM `ply1`.`Products` WHERE `ProductID` = '".$prodID."'";
			$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_array($rs);
			$newUnits = $row[UnitsInStock] - $quantity;
			$sql = "UPDATE `ply1`.`Products` SET `UnitsInStock` = '$newUnits' WHERE `ProductID` = '$prodID'";
			$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		}
	
	}
	//returns a resource, use mysql_fetch_array($rs) to get one row at a time
	function getAllProducts()
	{
		
		$sql = "SELECT `ProductID`,`ProductName`, `ProductDesc`, `UnitsInStock`, `Image`, `UnitPrice` FROM `ply1`.`Products`";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}
	//Returns an array
	function getOneProduct($prodID)
	{
		mysql_real_escape_string($prodID);
		$sql = "SELECT `ProductName`, `ProductDesc`, `UnitsInStock`, `Image`, `UnitPrice` FROM `ply1`.`Products` WHERE `ProductID` = ".$prodID."";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return mysql_fetch_array($rs);
	}
	function addProduct($productArr)
	{
		$name = mysql_real_escape_string($productArr[0]);
		$desc = mysql_real_escape_string($productArr[1]);
		$units = mysql_real_escape_string($productArr[2]);
		$image = mysql_real_escape_string($productArr[3]);
		$sql = "INSERT INTO `ply1`.`Products` (`ProductName`, `ProductDesc`, `UnitsInStock`, `Image`) VALUES ('".$name."', ".$desc.", '".$units."', '".$image."')";
		
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	}
	function deleteProduct($prodID)
	{
		mysql_real_escape_string($prodID);
		$sql = "DELETE FROM `ply1`.`Products` WHERE `ProductID` = '$prodID'";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);	
	}
	function updateProducts($prodID, $productArr)
	{
		$prodID = mysql_real_escape_string($prodID);
		$name = mysql_real_escape_string($productArr[0]);
		$desc = mysql_real_escape_string($productArr[1]);
		$units = mysql_real_escape_string($productArr[2]);
		$image = mysql_real_escape_string($productArr[3]);
		$sql = "UPDATE `ply1`.`Products` SET `ProductName` = '$name', `ProductDesc` = '$desc',
		`UnitsInStock` = '$units', `Image` = '$image' WHERE `ProductID` = '$prodID'";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	}
	function execute($sql)
	{
		return $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	}
	function executeQuery($sql, $filename) // execute query
	{
		$rs = mysql_query($sql, $this->conn) or die("Could not execute query '$sql' in $filename " . mysql_error()); 
		return $rs;
	}	
}	