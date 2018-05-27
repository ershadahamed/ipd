<?php include('manualdbconfig.php'); ?>

<style>
<?php 
	include('css/style2.css'); 
	include('css/button.css');
	include('css/pagination.css');
	include('css/grey.css');	
?>
</style>

<?php
if (isloggedin()) {
        add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
?>		
<?php
if(($USER->id)!='2'){ 
echo $OUTPUT->heading(get_string('mytrainingprogram'), 2, 'headingblock header'); 
}else{
    echo $OUTPUT->heading('Foundation module', 2, 'headingblock header'); 
}
?>
<?php //IPD candidate 
	$IPDstatement=" mdl_cifauser a, mdl_cifauser_program b WHERE a.id=b.userid AND a.deleted!='1' AND b.programid='1' AND b.userid='".$USER->id."'";
	$selIPD=mysql_query("SELECT * FROM {$IPDstatement}");
	$cIPD=mysql_num_rows($selIPD); 
?>
<table width="98%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td>
	<?php 
		if(($USER->id)!='2'){ 
		//if not administrator    
		echo '<fieldset id="fieldset">';
		/*SHAPE IPD*/ if($cIPD!='0'){ 
		echo '<legend id="legend" style="width: 15%"><b>'.ucwords(strtoupper(get_string('shapeipd'))).' '.ucwords(strtolower(get_string('courses'))).'</b></legend>';
		}else{
		echo '<legend id="legend" style="width: 15%"><b>'.ucwords(strtoupper(get_string('cifacurriculum'))).'</b></legend>';
		}
		include('userfrontpage/content1.php');
		echo '</fieldset>';
		}else{
			include_once ('pagingfunction.php');
			//if administrator
			echo '<fieldset id="fieldset">';
			include('userfrontpage/admin-courses.php');
			echo '</fieldset>';
		}
	?>
	</td></tr>
</table>
<?php }else{ 
	//if not loggin user
	echo $OUTPUT->heading(get_string('enrollnow'), 2, 'headingblock header');?>
	
<?php
 $sqlCourses="
	Select 
		*, b.id as enrolid
    From
        mdl_cifacourse a,
        mdl_cifaenrol b
    Where
        a.id = b.courseid And
        (a.category = '1' And
        b.enrol = 'paypal' And
        a.visible = '1' And
        b.status = '0')";				  
    $sqlCourses.=" Order By a.shortname Asc";
    $queryCourses=mysql_query($sqlCourses);	
?>	

<table width="100%"><tr valign="top"><td width="78%">
<table id="availablecourse3" width="100%">
<tr class="yellow">
	<th>IPD code</th>
	<th style="text-align:left;">IPD modules</th>
	<th style="text-align:center;">Price</th>
	<th style="text-align:center;">Action</th>
</tr>
<?php while($rowCourses=mysql_fetch_array($queryCourses)){ ?>
<tr>
	<td class="adjacent" style="text-align:center;"><?=$rowCourses['shortname']; ?></td>
	<td class="adjacent" style="text-align:left;">
		<h4><?=$rowCourses['fullname']; ?></h4>
		<?php if($rowCourses['summary'] !=''){ ?>
		<div style="text-align:justify; padding-bottom:10px;"><?=$rowCourses['summary'];?></div>
		<?php 
		}else{ 
		echo 'No summary';
		}
		?>
	</td>
	<td class="adjacent" style="text-align:center;"><?='$ '.$rowCourses['cost'];?></td>
	<td class="adjacent" style="text-align:center; vertical-align: center;">
		<!--a href="portal/subscribe/paydetails.php?id=<?//=$rowCourses['courseid'];?>"-->
		<div style="padding: 5px 0px 5px; cursor:pointer;">
		<img onclick="addtocart(<?=$rowCourses['courseid'];?>)" src="image/shopcartapply.png" width="30" title="Add to Cart - Purchase a <?php echo $rowCourses['fullname'];?>"/><!--/a-->	
		<!--input type="button" value="Add to Cart" onclick="addtocart(<?//=$rowCourses['courseid'];?>)" /--></div>
	</td>
</tr>
<?php } ?>
</table>



</td><td>
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
	<table style="background-color:#fff; border:1.8px solid #3D91CB;">
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
			<?php if($max>0){ ?>
			<tr><td colspan="2">&nbsp;</td><td><b>Order Total</b></td><td style="text-align:center;background-color: yellow"><b>$ <?=get_order_total();?></b></td></tr>
			<tr><td colspan="2">&nbsp;</td><td><b>Items in cart</b></td><td style="text-align:center;background-color: yellow"><b><?=$i;?></b></td></tr>
			<?php }else{ 
				echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
			}
			?>
		</table>
		<?php if($max>0){ ?>
		<div style="float:right;">
			<input style="cursor:pointer;" type="button" value="Clear Cart" onclick="clear_cart()">
			<input style="cursor:pointer;" type="button" value="Place Order" onclick="window.location='<?=$CFG->wwwroot;?>/billing.php?pid=<?=$pid;?>'">
		</div>
		<?php } ?>
		</td></tr><?php }else{ ?>
		<tr><td>There are no items in your shopping cart!</td></tr>
		<?php } ?>
	</table>
</td></tr></table>

<?php	
	//include('userfrontpage/reg-availablecourse.php'); 
 } ?>