<?php 
	session_start();
	include_once ("DBFuncs.php");
	include_once ("global.php");
	include_once ("layout.php");
	
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
   if ($_GET['page'])
   {
      if ($_GET['page'] == 'login')
      {
         include("login.html");
      }
      elseif ($_GET['page'] == 'create_account')
      {
         include("createAccount.html");
      }
	elseif ($_GET['page'] == 'cart')
      {
         include("cart.php");
      }
      else
      {
	  include("featured.php");
	  include("pagedView.php");
      }
   }
   else
   {
	  include("featured.php");
	  include("pagedView.php");
    }
}


?>