<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=MS932">
	<title>ShopMaster - Featured Item Section</title>
</head>

<body>
    <?php include DBFuncs.php;
    
    // I assume that I will get a connection if I do this.
    connect();
    
    // Copied and Modified Code from: http://php.net/manual/en/function.mysql-query.php
    
    // This could be supplied by a user, for example
    $featured = '1';
    
    // Formulate Query
    // This is the best way to perform an SQL query
    // For more examples, see mysql_real_escape_string()
    $query = sprintf("SELECT 'ProductName', 'ProductDesc', 'UnitsInStock', 'Image', 'UnitPrice' FROM 'ply1'.'Products' 
			WHERE 'Featured' = '$featured'");
    
    // Perform Query
    $result = mysql_query($query);
    
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
    	echo $row['ProductName'];
    	echo $row['ProductDesc'];
    	echo $row['Image'];
    	echo $row['UnitPrice'];
    	/*
    	 * This is where I am going to need to use some HTML to format things.
    	 * */
    }
    
    // Free the resources associated with the result set
    // This is done automatically at the end of the script
    mysql_free_result($result);
    
    // End of Copied and Modifed Code from: http://php.net/manual/en/function.mysql-query.php
    
    
	?>
</body>

</html>

