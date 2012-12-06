<?php 
  session_start();
  include_once ("DBFuncs.php");
  include_once ("global.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=MS932">
	<title>ShopMaster - Featured Item Section</title>
</head>

<body>
    <?php //<!-- Copied and Modified Code from: http://php.net/manual/en/function.mysql-query.php
    
    // I assume that I will get a connection if I do this. [Thanks Brian for fixing it.]
    global $db;
    
    // This could be supplied by a user, for example
    $featured = '1';
    
    // Formulate Query - This is the best way to perform an SQL query
    // For more examples, see mysql_real_escape_string()
    $query = "SELECT `ProductID`, `ProductName`, `ProductDesc`, `UnitsInStock`, `Image`, `UnitPrice` FROM `ply1`.`Products` WHERE `Featured` = '".$featured."'";
    
    // Perform Query [Thanks Brian again]
    $result = $db->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
    
    // Check result - This shows the actual query sent to MySQL, and the error. Useful for debugging.
    if (!$result)
    	{
    	$message  = 'Invalid query: ' . mysql_error() . "\n";
    	$message .= 'Whole query: ' . $query;
    	die($message);
    	}
    
    // Use result
    // Attempting to print $result won't allow access to information in the resource
    // One of the mysql result functions must be used
    // See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
    
    // initialize counters
    $countOfFeaturedItems = 0;
    $maxItems = 8;
    
    // Find out how many items are in the table
  	while ($row = mysql_fetch_assoc($result))
  		{
  		$countOfFeaturedItems += 1;
  		}
  	
  	// Print statement to check
    //echo "Items in table: ", $countOfFeaturedItems, "</br>";
    $maxFeaturedItemsIndex = $countOfFeaturedItems-1;
    
    //http://stackoverflow.com/questions/11239563/random-number-generation-without-duplicates
    $array = array();
    for($index = 0; $index < $countOfFeaturedItems && $index < $maxItems; $index++)
   		{
   		$randomNum = rand(0, $maxFeaturedItemsIndex);
   		while(in_array($randomNum, $array))
    		{
    		$randomNum = rand(0, ($maxFeaturedItemsIndex));
    		}
    	$array[] = $randomNum;
    	
    	// Print to Check
    	//echo "Got here ", $randomNum, "</br>";
   		}
   	
   	// Rest my pointer to the first element, else it will always be "false" because it is point to the last + 1 element which does not exist.
   	// Thanks to: http://forums.phpfreaks.com/topic/189495-mysql-fetch-assocresult-reset-pointer-mysql-data-seek-causes-page-to-fail/
   	mysql_data_seek($result, 0);

   	echo '<div id="products">';
   	// OKay, we have our random items, lets display them
   	for ($index = 0; $index < count($array); $index++)
   		{
   		mysql_data_seek($result, $array[$index]);
   		$row = mysql_fetch_array($result);
   		//<a href="items.php?prodID='.$row['ProductID'].'"><font color="0000FF">'. $row['ProductName'] .'</a>
   		
   		
    	//echo 'Featured Item!</br>'; //Leave this in for a staggered look.
    	
    	echo '<div class="product"><a href="items.php?prodID='.mysql_result($result, $array[$index], 'ProductID').'"><img src='.mysql_result($result, $array[$index], 'Image').'></br>'
    			. mysql_result($result, $array[$index], 'ProductName') .'</a>';
    	echo '</br>$'. mysql_result($result, $array[$index], 'UnitPrice') . '</div>';
    	
//     	echo $row['ProductDesc'], "<br>";
//     	echo "<img src=", $row['Image'], "></br>";
//     	echo "Price: $", $row['UnitPrice'], "</br>";
   		}
   		echo '</div></br></br>';
   		
   		
   		
    /* <a href="./items.php?prodID="<?php echo($prodID);?>"> 
     * Brian:  oh, when you need to link to the product page
     * 1 sec
     * Sent at 11:38 PM on Wednesday
     * Brian:  <a href="./items.php?prodID="<?php echo($prodID);?>">
     * or however you stored the product id
     * */
    


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
    
    // Free the resources associated with the result set
    // This is done automatically at the end of the script
    mysql_free_result($result);
    
    // End of Copied and Modifed Code from: http://php.net/manual/en/function.mysql-query.php
	?>
</body>

</html>

