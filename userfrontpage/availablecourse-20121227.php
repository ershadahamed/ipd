<style>
a {
    color: #0000FF;
    text-decoration: none;
}
</style>
<?php if (isloggedin()) { echo '<fieldset id="fieldset"><legend id="legend"><strong>'.$purchase.'</strong></legend>'; } ?>
<form name="searchform" method="post">
<table>	
<tr>
    <td width="70%" valign="center" >&nbsp; </td>
    <td width="30%" align="right" valign="center">
        <table width="100%" border="0" width="100%" style="padding:0; margin:0;"><tr><td align="right" width="95%">
        <input type="text" name="search" size="50" style="height:18px;">
        </td>
        <td align="right" width="5%">    
            <a href="javascript:document.searchform.submit()" onmouseover="document.searchform.sub_but.src='image/search.png'" 
            onmouseout="document.searchform.sub_but.src='image/search.png'"  onclick="return val_form_this_page()">
            <img src="image/search.png" width="25" border="0" alt="Submit this form" name="sub_but" />
            </a>               
        </td></tr></table>
    </td>
</tr>
</table>
</form>  
<table id="avalaiblecourse" style="width:98%; float:left;" border="0" cellpadding="0" cellspacing="0"><tr valign="top">
<td style="width:65%;">
<table id="avalaiblecourse" border="0" cellpadding="0" cellspacing="0">
<?php	
    $search=$_POST['search'];
    $sqlCourses="
		Select
		  *,
		  b.id As enrolid
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid
		Where
		  a.category = '1' And
		  b.enrol = 'manual' And
		  a.visible = '1' And
		  b.status = '0'
	";				  
    if($search!=''){$sqlCourses.=" And (a.fullname LIKE '%".$search."%' Or a.shortname LIKE '%".$search."%')";} 
    $sqlCourses.=" Order By a.id Desc";
    $queryCourses=mysql_query($sqlCourses);
    $count=mysql_num_rows($queryCourses);
    if($count>0){
      
    while($rowCourses=mysql_fetch_array($queryCourses)){
	$sqlC=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE userid='".$USER->id."' AND enrolid='".$rowCourses['enrolid']."'");
	$rowC=mysql_num_rows($sqlC);
	//echo $rowC;
?>	
<?php if($rowC == '0'){ ?>
<tr><td>
    <h4 class="name">
<?php } ?>
    <?php 
		if($rowC == '0'){
			$sqlse=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE traineeid='".$USER->traineeid."' AND (payment_status='Pending' OR payment_status='New') AND courseid='".$rowCourses['courseid']."'");
			$sqlcount=mysql_num_rows($sqlse);

			$sqlmodule=mysql_query("
				Select
				  *
				From
				  mdl_cifaorders a Inner Join
				  mdl_cifaorder_detail b On a.serial = b.orderid
				Where
				  a.customerid = '".$USER->id."' And b.productid='".$rowCourses['courseid']."'						
			");
			$countmodule=mysql_num_rows($sqlmodule);
			if($countmodule == '0'){
				
			?>	
			<div style="cursor:pointer;">
			<a style="text-decoration: none;" onclick="addtocart(<?=$rowCourses['courseid'];?>)" title="click to subscribe modules">
			<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a></div>
    <?php 	}} ?>
    </h4>
</td>
<?php if($rowC == '0'){  ?>  
<td rowspan="2">
	<?php if($countmodule == '0'){ ?>
		<div style="padding: 5px 0px 5px; cursor:pointer;">
		<img onclick="addtocart(<?=$rowCourses['courseid'];?>)" src="image/shopcartapply.png" width="30" title="Purchase a <?php echo $rowCourses['fullname'];?>"/>
		</div>
	<?php } ?>
</td></tr> 
<?php } ?>

<?php if($rowCourses['summary'] != ''){ ?>
<?php if($rowC == '0'){  ?> 
<tr><td style="padding-top:0px; padding-bottom:0px;">
<?php } ?>         
<?php 
	if($countmodule == '0'){
    if (isloggedin()) { 
        if(($USER->id)!='2'){
            //if user not purchase yet
            if($rowC == '0'){
            echo '<div style="text-align:justify; padding-bottom:10px;">'.$rowCourses['summary'].'</div>';
            }
        }else{
            echo '<div style="text-align:justify; padding-bottom:10px;">'.$rowCourses['summary'].'</div>';
        }
    }
	}
?>
<?php if($rowC == '0'){  ?> 
</td></tr>
<?php } ?> 
<?php }else{ ?>
<?php if($rowC == '0'){  ?> 
<tr><td style="padding-top:0px; padding-bottom:0px;">
<?php }  ?> 
<?php 
    //if user not purchase yet
    if($countmodule == '0'){
	if($rowC == '0'){
        echo "<div style='padding-bottom:10px;'>No summary.</div>";
    }
    }}
?>
<?php if($rowC == '0'){  ?>         
</td></tr>
<?php }  ?> 
<?php 

//not found search records.
}
if($rowC > '0'){
echo "No records found.";
}
}else{ echo "No records found.";} 

?>	</table></td>

<td style="float:right;">
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
	<?php if($rowC == '0'){ ?>
	<table style="background-color:#fff; border:1.8px solid #3D91CB;" >
		<tr><td style="background-color: #ccc"><b>Shopping Cart<b></td></tr>
		<?php if(is_array($_SESSION['cart'])){ ?>
		<tr><td>
		<table id="availablecourse3">			
			<?php 
			$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				$pid=$_SESSION['cart'][$i]['productid'];
				$q=$_SESSION['cart'][$i]['qty'];
				$pname=get_product_name($pid);
				if($q==0) continue;?>
				<tr><td><?=$q;?></td><td> X </td><td><?=$pname;?></td><td> $ <?=get_price($pid);?></td></tr>
				<?php } ?>

			<tr><td colspan="2">&nbsp;</td><td><b>Order Total</b></td><td style="text-align:center;background-color: yellow"><b>$ <?=get_order_total();?></b></td></tr>
			<tr><td colspan="2">&nbsp;</td><td><b>Items in cart</b></td><td style="text-align:center;background-color: yellow"><b><?=$i;?></b></td></tr>
		</table>
		<div style="float:right;">
			<input type="button" style="cursor:pointer;" value="Clear Cart" onclick="clear_cart()">
			<input type="button" style="cursor:pointer;" value="Place Order" onclick="window.location='<?=$CFG->wwwroot;?>/portal/subscribe/paydetails_loggeduser.php?pid=<?=$pid;?>'">
		</div>
		</td></tr>
	<?php }else{
				echo "<tr bgColor='#FFFFFF'><td class='adjacent' colspan='7'>There are no items in your shopping cart!</td></tr>";
			} ?>
	</table>
	<?php } ?>
	</td></tr></table>	
<?php if (isloggedin()) { ?></fieldset><?php if(($USER->id)=='2'){?></fieldset><?php }} ?>




