<?php
include_once('DBFuncs.php');
include_once('global.php');
include_once('layout.php');

$id = $_GET['prodID'];
$row = $db->getOneProduct($id);
?>
<SCRIPT language=Javascript>
      <!--
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
      //-->
   </SCRIPT>

<div id="items">
	<div class="item">
  		<img src='<?php echo($row['Image']);?>'>
		<div class="desc">
    			<div style="font-size:24pt;"><?php echo($row['ProductName']);?></div></br>
			<?php echo($row['ProductDesc']);?></br>
		</div>
		<div class="addCart">
  			<div style="vertical-align:text-bottom; font-size:18pt;">
 				 <FORM ACTION="cart.php?action=add" METHOD=POST>
 				 Quantity 
 				 <INPUT NAME="quantity" SIZE=3 MAXLENGTH=3 onkeypress="return isNumberKey(this);">
				$<?php echo($row['UnitPrice']);?>
  				<INPUT TYPE=SUBMIT VALUE="Add to Cart">
 				 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?php echo($id);?>">
  
				</FORM>
			</div>	
		</div>
  	</div>
</div>
<?php include_once ('footer.html');?>
  