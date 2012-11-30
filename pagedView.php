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
        VIEW-PAGINATED.PHP
        Displays all data from 'players' table
        This is a modified version of view.php that includes pagination
        
        THis code is from:
        http://www.killersites.com/community/index.php?/topic/1969-basic-php-system-vieweditdeleteadd-records/
	*/
        
        // number of results to show per page
        $per_page = 30;
        
        // figure out the total pages in the database
        $result = $db->getAllProducts();
        $total_results = mysql_num_rows($result);
        $total_pages = ceil($total_results / $per_page);

        // check if the 'page' variable is set in the URL (ex: view-paginated.php?page=1)
        if (isset($_GET['page']) && is_numeric($_GET['page']))
        {
                $show_page = $_GET['page'];
                
                // make sure the $show_page value is valid
                if ($show_page > 0 && $show_page <= $total_pages)
                {
                        $start = ($show_page -1) * $per_page;
                        $end = $start + $per_page; 
                }
                else
                {
                        // error - show first set of results
                        $start = 0;
                        $end = $per_page; 
                }               
        }
        else
        {
                // if page isn't set, show first set of results
                $start = 0;
                $end = $per_page; 
        }
        
        // display pagination
        echo "<p><a href='allView.php'>View All</a> | <b>View Page:</b> ";
        for ($i = 1; $i <= $total_pages; $i++)
        {
                echo "<a href='pagedView.php?page=$i'>$i</a> ";
        }
        echo "</p>";
                
        // display data in table
        echo "<table border='1' cellpadding='10'>";
        //echo "<tr> <th>Item</th> <th>Description</th></tr>";

        // loop through results of database query, displaying them in the table 
        for ($i = $start; $i < $end; $i++)
        {
                // make sure that PHP doesn't try to show results that don't exist
                if ($i == $total_results) { break; }
        	  if ($i % 6 == 0) { echo "</tr><tr>"; }
                // echo out the contents of each row into a table
                //echo "<tr>";
               echo '<td style="text-align:left" width="150" height="200"><a href="items.php?prodID='.mysql_result($result, $i, 'ProductID').'">
			<img src='.mysql_result($result, $i, 'Image'). ' width="150px" height="150px""></br>'
			. mysql_result($result, $i, 'ProductName') .'</a>';
                echo '</br>$'. mysql_result($result, $i, 'UnitPrice') . '</td>';
               // echo "<td><img src=\"",mysql_result($result, $i, 'Image'), "\" height=\"100\" style=\"max-width: 120px\"></td>";
                //echo '<td>' . mysql_result($result, $i, 'ImageName') . '</td>';
                //echo '<td><a href="edit.php?id=' . mysql_result($result, $i, 'id') . '">Edit</a></td>';
                //echo '<td><a href="delete.php?id=' . mysql_result($result, $i, 'id') . '">Delete</a></td>';
                //echo "</tr>"; 
        }
        // close table>
        echo "</tr></table>"; 
        
        // pagination
        
?>

</body>
</html>