<?php
	include_once ("DBFuncs.php");
	include_once ("global.php");
	include_once ("layout.php");
	session_start();

if ($_GET['action'] == shipping)
{
	include("shipping.html");
}
elseif ($_GET['action'] == billing)
{
	include("billing.html");
}
elseif ($_GET['action'] == complete)
{
	include("complete.php");
}


?>
