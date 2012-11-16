<?php
class dbConn
{
	var $conn;


	function connect()
	{
		$conn = mysql_connect("studentdb.gl.umbc.edu", "ply1", "ThereisnoP@ssw0rd")
			or die ("Could not connect to database" . mysql_error());
			
		mysql_select_db("ply1", $conn);
		
		$this->conn = $conn;
	}
	
	function userSignup($email, $pw)
	{
		$sql = "SELECT 'E-mail' FROM 'ply1.'Customers' WHERE 'E-mail' = '$email'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		
		if ($email == $row[0])
		{
			return false;
		}
		else
		{
			$sql = "INSERT INTO 'ply1'.'Customers' ('E-mail', 'Password')
				VALUES ('".$email."', '".$pw."')";
			$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			return true;
		}
	}	
	
	function userLogin($userName, $pw)
	{
		$sql = "SELECT 'CustomerID', 'Password' FROM 'ply1'.'Customers' WHERE 'E-mail' = '$userName'";
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
	function addOrder($items, $billInfo, $shipInfo)
	{	
		
		for($i = 0; $i <= count($items); $i++)
		{
			$sql = "INSERT INTO 'ply1'.'Order Items' ('OrderID', 'ProductID', 'UnitPrice', 'Quantity')
				VALUES ('".$orderID."','".$items[$i][0]."','".$items[$i][1]."','".$items[$i][2]."')";
			$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);	
		}
	
	}
	
	function addProduct($productArr)
	{
		$sql = "INSERT INTO `ply1`.`Products` (`ProductName`, `ProductDesc`, `UnitsInStock`, `Image`)
        		VALUES ('".$productArr[0]."', ".$productArr[1].", '".$productArr[2]."', '".$productArr[3]."')";
		
		$this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	}
	
	function updateProducts($productArr)
	{
	
	
	}
	
	function executeQuery($sql, $filename) // execute query
	{
		if($this->debug == true) { echo("$sql <br>\n"); }
		$rs = mysql_query($sql, $this->conn) or die("Could not execute query '$sql' in $filename"); 
		return $rs;
	}	
}	