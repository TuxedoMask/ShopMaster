<?php
	session_start();
	include_once ("DBFuncs.php");
	include_once ("global.php");
	include_once ("layout.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<body>

	<?php
	global $db;
/*
        VIEW.PHP
        Displays all data from 'players' table
        
        Borrowed from:
        http://www.killersites.com/community/index.php?/topic/1969-basic-php-system-vieweditdeleteadd-records/
*/

        // get results from database
        $result = $db->getAllProducts();  
                

        
//         echo "<table border='1' cellpadding='10'>";
//         echo "<tr> <th>Product</th> <th>Product Description</th> <th>Image of Product</th></tr>";

        // loop through results of database query, displaying them in the table
        $total_results = mysql_num_rows($result);
        echo '<br><br><br>';
        echo '<div id="products">';
        for ($i = 0; $i < $total_results; $i++)
        	{
        	// loop through results of database query, displaying them in the table
       		echo '<div class="product"><a href="items.php?prodID='.mysql_result($result, $i, 'ProductID').'"><img src='.mysql_result($result, $i, 'Image').'></br>'
			. mysql_result($result, $i, 'ProductName') .'</a>';
			echo '</br>$'. mysql_result($result, $i, 'UnitPrice') . '</div>';
        	}
        echo '</div>';
        
        if ($total_results == 0)
        {
        	echo '<center>There are no items for sale today. Check back later!</center><br>';
        }
        	
//             // echo out the contents of each row into a table [Old Style]
//             echo "<tr>";
//             $row = mysql_fetch_array($result);
//             echo '<td><a href="items.php?prodID='.$row['ProductID'].'">'. mysql_result($result, $i, 'ProductName') .'</a></td>';
// //            echo '<td>' . mysql_result($result, $i, 'ProductName') . '</td>';
//             echo '<td>' . mysql_result($result, $i, 'ProductDesc') . '</td>';
//             echo "<td><img src=\"",mysql_result($result, $i, 'Image'), "\" height=\"100\" style=\"max-width: 120px\"></td>";
//             //echo '<td>' . mysql_result($result, $i, 'ImageName') . '</td>';
//             //echo '<td><a href="edit.php?id=' . mysql_result($result, $i, 'id') . '">Edit</a></td>';
//             //echo '<td><a href="delete.php?id=' . mysql_result($result, $i, 'id') . '">Delete</a></td>';
//             echo "</tr>";
//             echo "";
//        	}

        // close table>
        echo "</table>";
        
        // display links to view styles
        echo "<center><b>View All</b> | <a href='pagedView.php?page=1'>View Paginated</a></center>";
?>
</body>
</html> 