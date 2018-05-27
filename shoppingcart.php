<?php
    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include("manualdbconfig.php");
	include("includes/functions.php");	

	$site = get_site();	
	
	$title="$SITE->shortname: Courses";
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	if (isloggedin()) {
	$PAGE->set_pagelayout('courses');
	}
	
	echo $OUTPUT->header();
?>
<?php
	if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
		remove_product($_REQUEST['pid']);
	}
	else if($_REQUEST['command']=='clear'){
		unset($_SESSION['cart']);
	}
	else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=intval($_REQUEST['product'.$pid]);
			if($q>0 && $q<=999){
				$_SESSION['cart'][$i]['qty']=$q;
			}
			else{
				$msg='Some proudcts not updated!, quantity must be a number between 1 and 999';
			}
		}
	}

?>
<script language="javascript">
	function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.formcart.pid.value=pid;
			document.formcart.command.value='delete';
			document.formcart.submit();
		}
	}
	function clear_cart(){
		if(confirm('This will empty your shopping cart, continue?')){
			document.formcart.command.value='clear';
			document.formcart.submit();
		}
	}
	function update_cart(){
		document.formcart.command.value='update';
		document.formcart.submit();
	}


</script>
<style>
<?php 
	include('css/style2.css'); 	
?>
</style>
<form name="formcart" method="post">
<input type="hidden" name="pid" />
<input type="hidden" name="command" />
	<fieldset id="fieldset"><legend id="legend"><strong>List of subscribe module</strong></legend>
	<div style="margin:0px auto; width:95%;" >
    
	<div style="padding:20px 0px 10px">
    <!--h1 align="center">List of purchasing module</h1-->
    <input type="button" value="Add New Subscribe" onclick="window.location='coursesindex.php'" />
    </div>
    	<div style="color:#F00"><?php echo $msg?></div>
    	<!--table border="0" cellpadding="5px" cellspacing="1px" style="font-family:Verdana, Geneva, sans-serif; font-size:11px; background-color:#E1E1E1" width="100%"-->
		<table id="availablecourse3" width="100%">
    	<?php
			if(is_array($_SESSION['cart'])){
            	echo '<tr class="yellow" bgcolor="#FFFFFF" style="font-weight:bold">
						<th width="1%">No.</th>
						<th width="45%">IPD Name</th>
						<th width="15%">IPD Code</th>
						<th width="10%" align="center">Price</th>
						<th width="10%" align="center">Qty</th>
						<th width="10%" align="center">Amount</th>
						<th width="9%" align="center">Options</th>
					</tr>';
				$max=count($_SESSION['cart']);
				for($i=0;$i<$max;$i++){
					$pid=$_SESSION['cart'][$i]['productid'];
					$q=$_SESSION['cart'][$i]['qty'];
					$pname=get_product_name($pid);
					if($q==0) continue;
			?>
            		<tr bgcolor="#FFFFFF">
					<td class="adjacent" ><?php echo $i+1?></td>
					<td class="adjacent" ><?php echo $pname?></td>
					<td class="adjacent" style="text-align:center;"><?php echo get_product_code($pid);?></td>
                    <td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)?></td>
                    <td class="adjacent" style="text-align:center;"><input type="hidden" name="product<?php echo $pid?>" value="<?php echo $q?>" maxlength="3" size="2" /><?php echo $q?></td>                    
                    <td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)*$q?></td>
                    <td class="adjacent" style="text-align:center;"><!--a href="javascript:del(<?php// echo $pid?>)">Remove</a-->
					<div style="cursor:pointer; padding:5px;">
					<img onclick="javascript:del(<?php echo $pid?>)" src="image/delete2.png" width="20" title="Remove a purchase - <?=$pname;?>"/></div>
					</td></tr>
            <?php					
				}
			?>
				<tr style="height:33px;">
					<td class="adjacent"  colspan="7" width="70%"><b>Order Total: $ <?php echo get_order_total()?></b><!--/td>
					<td colspan="3" align="right"-->
						<div style="float:right;"><input type="button" value="Clear Cart" onclick="clear_cart()">
						<!--input type="button" value="Update Cart" onclick="update_cart()"-->
						<input type="button" value="Place Order" onclick="window.location='billing.php'"></div>
					</td>
				</tr>
			<?php
            }
			else{
				echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
			}
		?>
        </table>
    </div></fieldset>
</form>
<?php	
	echo $OUTPUT->footer();
?>