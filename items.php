<?php
include_once('DBFuncs.php');
include_once('global.php');
include_once('layout.php');

$id = $_GET['prodID'];
$row = $db->getOneProduct($id);
?>
<html>
<head>
<SCRIPT TYPE="text/javascript">
<!--
// copyright 1999 Idocs, Inc. http://www.idocs.com
// Distribute this script freely but keep this notice in place
function numbersonly(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) || 
    (key==9) || (key==13) || (key==27) )
   return true;

// numbers
else if ((("0123456789").indexOf(keychar) > -1))
   return true;

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}

//-->
</SCRIPT>
</head>
<center>
<table style="width:70%">
  <tr style="width:300px">
    <td style="text-align:left"><font size=20><?php echo($row['ProductName']);?></font></td>
	<td style="text-align:right"><font size=20>$<?php echo($row['UnitPrice']);?></font></td>
  </tr>
  <tr>
	<td width="300" height="300"><img src='<?php echo($row['Image']);?>' width="100%"></td>
	<td style="text-align:right"><?php echo($row['ProductDesc']);?></td>
  </tr>
  <tr><td>
  <FORM ACTION="cart.php?action=add" METHOD=POST>
  Quantity 
  <INPUT NAME="quantity" SIZE=5 MAXLENGTH=5
   onKeyPress="return numbersonly(this, event)">
  <INPUT TYPE=SUBMIT VALUE="Add to Cart">
  <INPUT TYPE=HIDDEN NAME="id" VALUE="<?php echo($id);?>">
  </td></tr>
</FORM>
  
  
  