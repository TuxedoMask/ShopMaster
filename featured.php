<?php 
  include_once ("DBFuncs.php");
  session_start(); 
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=MS932">
	<title>ShopMaster - Featured Item Section</title>
</head>

<body>
    <?php 
    // I assume that I will get a connection if I do this. [Thanks Brian for fixing it.]
    $dbConn = new DBFuncs();
    
    // Copied and Modified Code from: http://php.net/manual/en/function.mysql-query.php
    
    // This could be supplied by a user, for example
    $featured = '1';
    
    // Formulate Query
    // This is the best way to perform an SQL query
    // For more examples, see mysql_real_escape_string()
    $query = "SELECT `ProductName`, `ProductDesc`, `UnitsInStock`, `Image`, `UnitPrice` FROM `ply1`.`Products` 
			WHERE `Featured` = '".$featured."'";
    
    // Perform Query [Thanks Brian again]
    $result = $dbConn->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
    
    // Check result
    // This shows the actual query sent to MySQL, and the error. Useful for debugging.
    if (!$result) {
    	$message  = 'Invalid query: ' . mysql_error() . "\n";
    	$message .= 'Whole query: ' . $query;
    	die($message);
    }
    
    // Use result
    // Attempting to print $result won't allow access to information in the resource
    // One of the mysql result functions must be used
    // See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
    while ($row = mysql_fetch_assoc($result)) {
    	echo $row['ProductName'], "<br>";
    	echo $row['ProductDesc'], "<br>";
    	echo "<img src=", $row['Image'], "></br>";
    	echo "Price: $", $row['UnitPrice'], "</br>";
    	/*
    	 * This is where I am going to need to use some HTML to format things.
    	 * I want to have:
    	 * - a layout of six items in the center
    	 * - cannot all be the same,
    	 * - cannot be random items
    	 * 	- can be random featured items if there are more than 6
    	 * - can be in random order hence the above statement
    	 * 
    	 * That said, here is some idea code:
<!-- Here is the SALES section -->
<!-- Here is the images for those items: need about six or so. -->
<frameset rows="16%,16%,16%,%4,16%,16%,16%" >
	<frame src="itemA.html" scrolling="no" noresize frameborder="0">
	<frame src="itemB.html" scrolling="no" noresize frameborder="0">
	<frame src="itemC.html" scrolling="no" noresize frameborder="0">
		<frame src="" scrolling="no" noresize frameborder="0"> <!-- This should be blank as the center piece -->
	<frame src="itemD.html" scrolling="no" noresize frameborder="0">
	<frame src="itemE.html" scrolling="no" noresize frameborder="0">
	<frame src="itemF.html" scrolling="no" noresize frameborder="0">
<!-- Bottom stuffs use frames for lower portion. -->
</frameset>
    	 */
    }
    
    // Free the resources associated with the result set
    // This is done automatically at the end of the script
    mysql_free_result($result);
    
    // End of Copied and Modifed Code from: http://php.net/manual/en/function.mysql-query.php
    
    
	?>
</body>

</html>

