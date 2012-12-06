<?php
	session_start();
	include_once ("DBFuncs.php");
	include_once ("global.php");
	include_once ("layout.php");
	
?>


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
        $per_page = 24;
        
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
        
        
                
       

        // loop through results of database query, displaying them in the table 
        echo '<div id="products">';
for ($i = $start; $i < $end; $i++)
        {
			if ($i == $total_results) {break;}
			echo '
				<div class="product"><a href="items.php?prodID='.mysql_result($result, $i, 'ProductID').'"><img src='.mysql_result($result, $i, 'Image').'></br>'
			. mysql_result($result, $i, 'ProductName') .'</a>';
			echo '</br>$'. mysql_result($result, $i, 'UnitPrice') . '</div>';
        }
echo '</div>';	
        
        
        // display pagination
        echo "<center><a href='allView.php'>View All</a> | <b>View Page:</b> ";
        for ($i = 1; $i <= $total_pages; $i++)
        {
                echo "<a href='pagedView.php?page=$i'>$i</a> ";
        }
        echo "</center>";
include_once("footer.html");        
?>

