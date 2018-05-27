<?php /*if (isloggedin()) { echo '<fieldset id="fieldset"><legend id="legend"><strong>'.$purchase.'</strong></legend>'; }*/ ?>
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
<td style="width:70%;">
<table id="avalaiblecourse" style="background-color:#fff; width:100%;" cellpadding="0" cellspacing="0" >
<?php	
    $search=$_POST['search'];
	//kira row yang sudah di enrol
    $kiraenrol="
		Select
		  a.fullname
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid
		Where
		  c.userid = '".$USER->id."' And
		  b.enrol = 'manual' And
		  a.category = '1' And
		  a.visible = '1' And
		  b.status = '0'
	";		
	$kiraquery=mysql_query($kiraenrol);
	$kirarow=mysql_num_rows($kiraquery);
	//echo $kirarow; //end kira row yang sudah di enrol
	
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
    $sqlCourses.=" Order By a.id ASC";
    $queryCourses=mysql_query($sqlCourses);
    $count=mysql_num_rows($queryCourses);

    if($count>0){

    while($rowCourses=mysql_fetch_array($queryCourses)){
	$sqlC=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE userid='".$USER->id."' AND enrolid='".$rowCourses['enrolid']."'");
	$rowC=mysql_num_rows($sqlC);
?>	
<?php if($rowC == '0'){ ?>
<tr><td>
    <h4 class="name">
<?php } ?>
    <?php 
		if($rowC == '0'){
			$senroluser=mysql_query("Select * From mdl_cifaenrol Where enrol = 'manual' And courseid='".$rowCourses['courseid']."' And status='0'");
			$qenroluser=mysql_fetch_array($senroluser);
			$getenrolid=$qenroluser['id'];
			$gotuser=$sgetuser['candidateid'];			
			
			$scuser=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE enrolid='".$getenrolid."' AND userid='".$gotuser."'");
			$ucount=mysql_num_rows($scuser);			
			
			
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
			//echo $ucount;
			if($ucount == '0'){
				$statement=" mdl_cifacandidates a Inner Join mdl_cifaorders b On a.serial = b.customerid Inner Join mdl_cifaorder_detail c On b.serial = c.orderid";		
				$sqlcourse2="SELECT * FROM {$statement} WHERE c.productid='".$rowCourses['courseid']."' AND a.traineeid = '".$USER->traineeid."'";
				$sqlcourse2.=" Order By b.date DESC, a.traineeid DESC";		
				$sqlquery=mysql_query($sqlcourse2);
				$sqlgot=mysql_fetch_array($sqlquery);
				$statuspending='pending';
			?>	
			<div style="cursor:pointer;">
			<?php if($sqlgot['paystatus']==$statuspending){ ?>			
			<a style="text-decoration: none;" onClick='alert("You already subscribe this module <?=ucwords(strtoupper($rowCourses['shortname']));?> and status still <?=ucwords(strtoupper($sqlgot['paystatus']));?>.\nPlease proceed with your payment OR Please contact administrator for more information.")' title="click to subscribe modules">
			<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['idnumber'];?></a>
			<?php }else{ ?>
			<a style="text-decoration: none;" onclick="addtocart(<?=$rowCourses['courseid'];?>)" title="click to subscribe modules">
			<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['idnumber'];?></a>			
			<?php } ?>
			</div>
	<?php }} ?>
    </h4>
</td>
<?php if($rowC == '0'){  ?>  
<td><div style="float: right;padding: 5px 0px 5px; cursor:pointer;">
	<?php if($ucount == '0'){ ?>
	<?php
		if($sqlgot['paystatus']==$statuspending){?>
		<img onClick='alert("You already subscribe this module <?=ucwords(strtoupper($rowCourses['shortname']));?> and status still <?=ucwords(strtoupper($sqlgot['paystatus']));?>.\nPlease proceed with your payment OR Please contact administrator for more information.")' src="image/shopcartapply.png" width="30" title="Purchase a <?php echo $rowCourses['fullname'];?>"/>		
	<?php }else{ ?>
		<img onclick="addtocart(<?=$rowCourses['courseid'];?>)" src="image/shopcartapply.png" width="30" title="Purchase a <?php echo $rowCourses['fullname'];?>"/>		
	<?php } ?>
	<?php } ?>
	</div>
</td></tr> 
<?php } ?>

<?php 

//not found search records.
}
}else{ echo "No records found.";} 

if($kirarow == $count){ echo "No available training program.";} 

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

	<?php if($kirarow != $count){ ?>
	<table style="width:100%; background-color:#fff; border:1.8px solid #3D91CB;" >
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
			<input type="button" style="cursor:pointer;" value="View Order" onclick="window.location='<?=$CFG->wwwroot;?>/portal/subscribe/paydetails_loggeduser.php?pid=<?=$pid;?>'">
		</div>
		</td></tr>
	<?php }else{
				echo "<tr bgColor='#FFFFFF'><td class='adjacent' colspan='7'>There are no items in your shopping cart!</td></tr>";
			} ?>
	</table>
	<?php } ?>
	</td></tr></table>	
<?php /*if (isloggedin()) { ?></fieldset><?php if(($USER->id)=='2'){?></fieldset><?php }}*/ ?>




