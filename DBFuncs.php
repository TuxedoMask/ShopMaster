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
		$sql = "SELECT `FirstName` FROM `ply1`.`Customers` WHERE `CustomerID` = '".$userID."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		return $row['FirstName'];
	}
	function userSignup($email, $pw)
	{
		$sql = "SELECT * FROM `ply1`.`Customers` WHERE `E-mail` = '".$email."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		if (mysql_num_rows($rs) > 0)
		{
			return 0;
		}
		$sql = "INSERT INTO `ply1`.`Customers` (`E-mail`, `Password`)
			VALUES ('".$email."', '".$pw."')";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		
		$sql = "SELECT `CustomerID` FROM `ply1`.`Customers` WHERE `E-mail` = '".$email."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_assoc($rs);
		return $row['CustomerID'];
		
	}	
	
	function userLogin($userName, $pw)
	{
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
		//echo($items[0] . " " . $items[1]." ".$items[2]);
		$sql = "INSERT INTO `ply1`.`Orders` (`CustomerID`, `OrderDate`, `ShipName`, `ShipEmail`, `ShipPhone`,
			`ShipAddress`, `ShipCity`, `ShipCountry`, `ShipPostalCode`, `ShipState`) VALUES ('".$custid."', '$shipInfo[OrderDate]',
			'".$shipInfo[ShipName]."', '".$shipInfo[ShipEmail]."', '".$shipInfo[ShipPhone]."', '".$shipInfo[ShipAddress]."', '".$shipInfo[ShipCity]."',
			'".$shipInfo[ShipCountry]."', '".$shipInfo[ShipPostalCode]."', '".$shipInfo[ShipState]."')";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
		$orderID = mysql_insert_id();

		$sql = "UPDATE `ply1`.`Customers` SET `LastName` = '$billInfo[LastName]', `FirstName` = '$billInfo[FirstName]', `PhoneNo` = '$billInfo[PhoneNo]',
			`Address` = '$billInfo[Address]', `City` = '$billInfo[City]', `Country` = '$billInfo[Country]', `PostalCode` = '$billInfo[PostalCode]'
			WHERE `CustomerID` = '$custid'";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
		
		for($i = 0; $i < count($items); $i++)
		{
			$sql = "INSERT INTO `ply1`.`Order Details` (`OrderID`, `ProductID`, `UnitPrice`, `Quantity`)
				VALUES ('".$orderID."','".$items[$i++]."','".$items[$i++]."','".$items[$i]."')";
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
		$sql = "SELECT `ProductName`, `ProductDesc`, `UnitsInStock`, `Image`, `UnitPrice` FROM `ply1`.`Products` 
			WHERE `ProductID` = '".$prodID."'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return mysql_fetch_array($rs);
	}
	function addProduct($productArr)
	{
		$sql = "INSERT INTO `ply1`.`Products` (`ProductName`, `ProductDesc`, `UnitsInStock`, `Image`)
        		VALUES ('".$productArr[0]."', ".$productArr[1].", '".$productArr[2]."', '".$productArr[3]."')";
		
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	}
	function deleteProduct($prodID)
	{
		$sql = "DELETE FROM `ply1`.`Products` WHERE `ProductID` = '$prodID'";
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);	
	}
	function updateProducts($prodID, $productArr)
	{
		$sql = "UPDATE `ply1`.`Products` SET `ProductName` = '$productArr[0]', `ProductDesc` = '$productArr[1]',
		`UnitsInStock` = 'productArr[2]', `Image` = 'productArr[3]' WHERE `ProductID` = '$prodID'";
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