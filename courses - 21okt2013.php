<?php include('manualdbconfig.php'); $PAGE->set_pagelayout('course'); ?>

<style>
<?php 
	include('css/style2.css'); 
	//include('css/style.css'); 
	include('css/button.css');
	//include('css/pagination.css');
	//include('css/grey.css');	
?>
</style>

<?php
if (isloggedin()) {
        add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
?>		
<?php
if(($USER->id)!='2'){ 
	//echo $OUTPUT->heading(get_string('mytrainingprogram').' - '.get_string('ipdcourses'), 2, 'headingblock header'); 
	//echo '<br />';
}else{
    echo $OUTPUT->heading('Foundation module', 2, 'headingblock header'); 
}
?>
<?php //IPD candidate 
	$IPDstatement=" mdl_cifauser a, mdl_cifauser_program b WHERE a.id=b.userid AND a.deleted!='1' AND b.programid='1' AND b.userid='".$USER->id."'";
	$selIPD=mysql_query("SELECT * FROM {$IPDstatement}");
	$cIPD=mysql_num_rows($selIPD);


	$choose=mysql_query("
		Select
		  a.fullname,
		  b.courseid,
		  c.enrolid,
		  d.firstname,
		  d.lastname,
		  c.userid,
		  c.timecreated
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On a.id = b.courseid Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
		  mdl_cifauser d On c.userid = d.id
		Where
		  (b.courseid != '12' And
		  b.courseid != '44' And
		  b.courseid != '57') And
		  c.userid = '".$USER->id."'	
	");
	$sqlrow=mysql_num_rows($choose);
	$oneid=mysql_fetch_array($choose);
?>

<table width="98%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td>
	<?php 
		if(($USER->id)!='2'){ 
			//if not administrator    
				
			if($sqlrow>='2'){ //jika bil. lebih dari 1
			//echo '<fieldset id="fieldset" style="width:80%;">';
			echo '<fieldset style="padding: 0.6em;" id="user" class="clearfix">';
			if($cIPD!='0'){ /*SHAPE IPD*/ 
				// '<legend id="legend" style="width: 15%"><b>'.get_string('ipdcourses').'</b></legend>';
				echo '<legend style="font-weight:bolder;" class="ftoggler">'.get_string('ipdcourses').'</legend>';
			}else{
				/* echo '<legend id="legend" style="width: 15%"><b>'.ucwords(strtoupper(get_string('cifacurriculum'))).'</b></legend>'; */
				echo '<legend style="font-weight:bolder;" class="ftoggler">'.get_string('cifacurriculum').'</legend>';
			}				
				include('userfrontpage/content1.php');
				//include('userfrontpage/coursedetails.php');
				echo '</fieldset>';
			}else if(($sqlrow=='1')){			
				//include('userfrontpage/coursedetails.php'); //jika bilangan kursus hanya 1
				include('userfrontpage/content1.php');
			}else{
				echo 'No records found.';
			}
		}else{
			include_once ('pagingfunction.php');
			//if administrator
			include('userfrontpage/admin-courses.php');
		}
	?>
	</td></tr>
</table>
<?php }else{ 
	//if not loggin user
	//echo $OUTPUT->heading(get_string('enrollnow'), 2, 'headingblock header');?>	
<?php
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
    $sqlCourses.=" Order By a.idnumber Asc";
    $queryCourses=mysql_query($sqlCourses);	
?>	
<style>
#shopcart img{max-width:80%;}
</style>
<table id="shopcart" width="80%" border="0" style="text-align:left;">
	<tr>
	<td><img src="image/step1_select_program.png" width="80%"></td>   
	</tr>
</table>
<table width="100%"><tr valign="top"><td width="78%">
<table id="availablecourse" width="100%">
<tr class="yellow">
	<!--th>IPD code</th-->
	<th style="text-align:left;">Curriculum Details</th>
	<th style="text-align:center;">Price</th>
	<!--th style="text-align:center;">Action</th-->
</tr>
<?php while($rowCourses=mysql_fetch_array($queryCourses)){ ?>
<tr>
	<!--td class="adjacent" style="text-align:center;"><?//=$rowCourses['idnumber']; ?></td-->
	<td class="adjacent" style="text-align:left;">
		<b>Title: </b><?=$rowCourses['fullname']; ?>
		<?php if($rowCourses['summary'] !=''){ ?>
		<div style="text-align:justify; padding-bottom:10px;"><b>Synopsis:</b> <?=$rowCourses['summary'];?></div>
		<?php 
		}else{ 
		echo 'No summary';
		}
		?>
	</td>
	<td class="adjacent" style="text-align:center; width:15%;"><b><?='$'.$rowCourses['cost'];?></b><br/> 
	<input type="image" src="image/buy_now.png" name="buy_now" onclick="addtocart(<?=$rowCourses['courseid'];?>)" title="Buy Now" width="80" >	
	</td>
	<!--td class="adjacent" style="text-align:center; vertical-align: center;">
		<div style="padding: 5px 0px 5px; cursor:pointer;">
		<img onclick="addtocart(<?//=$rowCourses['courseid'];?>)" src="image/shopcartapply.png" width="30" title="Add to Cart - Purchase a <?php //echo $rowCourses['fullname'];?>"/>	
		</div>
	</td-->
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
		<div style="text-align:center;">
			<!--input style="cursor:pointer;" type="button" value="Clear Cart" onclick="clear_cart()"-->
			<!--input style="cursor:pointer;" type="button" value=" Proceed " onclick="window.location='<?//=$CFG->wwwroot;?>/billing.php?pid=<?//=$pid;?>'"-->
			<img style="cursor:pointer;" onclick="clear_cart()" src="image/clear_cart.png" width="80" title="Clear cart"/>
			<img style="cursor:pointer;" onclick="window.location='<?=$CFG->wwwroot;?>/billing.php?pid=<?=$pid;?>'" src="image/proceed_button.png" width="80" title="Proceed to next step"/>
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