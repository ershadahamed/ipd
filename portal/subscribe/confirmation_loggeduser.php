<?php 
    require_once('../../config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
	include('../../manualdbconfig.php'); 
	require_once("../../includes/functions.php"); 

	$site = get_site();
	
	$purchase='Purchase modules';
	$titlelms="$SITE->shortname: Courses - ".$purchase;
	$PAGE->set_title($titlelms);
	$PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    $buy_cifa='Buy Cifa';
	$buyipd=get_string('buyacifa');
	$selectprogram='Select Program';
	$your_details='Your Details';
	$pay_details='Payment Method';
	$PAGE->navbar->add($buyipd)->add($selectprogram)->add($your_details)->add($pay_details);	

	echo $OUTPUT->header();	
	
	$extendcost='50'; 	//cost for extend course
	$resitcost='50';	//cost for re-sit exam
	$id=$_POST['id'];
	$sql_ = mysql_query("SELECT * FROM mdl_cifacourse WHERE id='$id' ORDER BY id DESC");
	$row = mysql_fetch_array($sql_); 
	
	//candidate info //optional
	$traineeID = $_POST['traineeid'];
	$titlename=$_POST['title'];
	$middlename = $_POST['middlename'];
	$address = $_POST['trainee_address'];
	$address2 = $_POST['address2'];
	$address3 = $_POST['address3'];
	$state = $_POST['state'];	
	
	//candidate info //wajib isi
	$firstname = $_POST['name'];
	$lastname = $_POST['lastname'];	
	$dob=$_POST['dob'];
	$gender=$_POST['gender'];
	$email = $_POST['email'];
	$city = $_POST['city'];
	$postcode = $_POST['postcode'];
    $country = $_POST['country'];
	$phone = $_POST['phone_no'];

	$co1=$_POST['column1']; //wajib isi
	$co2=$_POST['column2'];
	$co3=$_POST['column3'];	//wajib isi
?>
<style>
<?php 
	include('../../css/style2.css'); 	
?>
</style>

<?php
	//idle time
	include('../../js/js_idletime.php');
	if($_GET['extendid']=='3'){
	$link=$CFG->wwwroot .'/portal/subscribe/subscribedetails_extend.php?traineeID='.$traineeID.'&titlename='.$titlename.'&name='.$firstname.'&middlename='.$middlename.'&lastname='.$lastname.'&gender='.$gender.'&dob='.$dob.'&address='.$address.'&address2='.$address2.'&address3='.$address3.'&email='.$email.'&phone='.$phone.'&state='.$state.'&city='.$city.'&postcode='.$postcode.'&country='.$country.'&co1='.$co1.'&co2='.$co2.'&co3='.$co3.'&extendid=3';
	}else if($_GET['extendid']=='4'){
	$link=$CFG->wwwroot .'/portal/subscribe/subscribedetails_extend.php?traineeID='.$traineeID.'&titlename='.$titlename.'&name='.$firstname.'&middlename='.$middlename.'&lastname='.$lastname.'&gender='.$gender.'&dob='.$dob.'&address='.$address.'&address2='.$address2.'&address3='.$address3.'&email='.$email.'&phone='.$phone.'&state='.$state.'&city='.$city.'&postcode='.$postcode.'&country='.$country.'&co1='.$co1.'&co2='.$co2.'&co3='.$co3.'&extendid=4&resitid='.$_GET['resitid'];
	}else{
	$link=$CFG->wwwroot .'/portal/subscribe/subscribedetails_loggeduser.php?traineeID='.$traineeID.'&titlename='.$titlename.'&name='.$firstname.'&middlename='.$middlename.'&lastname='.$lastname.'&gender='.$gender.'&dob='.$dob.'&address='.$address.'&address2='.$address2.'&address3='.$address3.'&email='.$email.'&phone='.$phone.'&state='.$state.'&city='.$city.'&postcode='.$postcode.'&country='.$country.'&co1='.$co1.'&co2='.$co2.'&co3='.$co3;		
	}
?>	
<!--*************************************************FORM AREA*********************************************************************************-->
<form id="form1" name="form1" method="post" action="">	

<!--- step by step----->
<style>
#shopcart img{max-width:80%;}
</style>
<table id="shopcart" width="80%" border="0" style="text-align:left;">
	<tr>
	<td width="20%" align="center"><img src="../../image/step3_payment.png" width="80%"></td>  
	</tr>
</table>

<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Shopping Cart</legend>
<div style="margin:0px auto; width:95%;">
<div style="padding-bottom:10px">
</div>
	<div style="color:#F00"><?php echo $msg?></div>
	<table id="availablecourse2" width="100%">
	<?php
		if(is_array($_SESSION['cart'])){
			echo '<tr class="yellow" bgcolor="#FFFFFF" style="font-weight:bold">
					<th width="1%" align="center">No.</th>
					<th width="45%">IPD Name</th>
					<th width="10%" style="text-align:center;">Price</th>
					<th width="10%" style="text-align:center;">Amount</th>
				</tr>';
			$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				$pid=$_SESSION['cart'][$i]['productid'];
				$q=$_SESSION['cart'][$i]['qty'];
				$pname=get_product_name($pid);
				if($q==0) continue;
				
		// resit ID
		$cfinaltestsql=mysql_query("
			Select
			  a.category,
			  a.fullname,
			  b.course,
			  b.instance,
			  c.id As cifaquizid,
			  c.name,
			  c.course As course1,
			  e.userid,
			  b.id As id1,
			  c.attempts,
			  a.idnumber
			From
			  mdl_cifacourse a Inner Join
			  mdl_cifacourse_modules b On a.id = b.course Inner Join
			  mdl_cifaquiz c On b.course = c.course And b.instance = c.id Inner Join
			  mdl_cifaenrol d On c.course = d.courseid Inner Join
			  mdl_cifauser_enrolments e On d.id = e.enrolid
			Where
			  e.userid='".$USER->id."'	And b.course='".$pid."' And	c.id='".$_GET['resitid']."'
		");
		$finalarray=mysql_fetch_array($cfinaltestsql); 
		$finalexamid=$finalarray['cifaquizid'];	
		$examname=$finalarray['name'].' - ('.get_string('resitexam').')';				
		?>
				<tr bgcolor="#FFFFFF">
					<td class="adjacent" style="text-align:center;"><?php echo $i+1?></td>
				<td class="adjacent" style="text-align:left;"><?php if($_GET['extendid']=='4'){ echo $examname; }else{ echo $pname; }?>&nbsp;
				<?php
					if($_GET['extendid']=='3'){
						echo get_string('extension');
					}
				?>					
				</td>
                <?php if($_GET['extendid']=='3'){ ?>
				<td class="adjacent" style="text-align:center;">$ <?=$extendcost;?></td>
				<td class="adjacent" style="text-align:center;">$ <?php echo ($extendcost*$q);?></td>
				<?php }else if($_GET['extendid']=='4'){ ?>
				<td class="adjacent" style="text-align:center;">$ <?=$resitcost;?></td>
				<td class="adjacent" style="text-align:center;">$ <?php echo ($resitcost*$q);?></td>                
				<?php }else{ ?>
				<td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)?></td>
				<td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)*$q?></td>
                <?php } ?>
				</tr>
		<?php					
			}
		?>
			<tr style="height:30px;">
				<td class="adjacent" colspan="2" width="70%">&nbsp;</td>
				<td class="adjacent" style="text-align:right;"><b>Order Total</b></td>
				<?php if($_GET['extendid']=='3'){ ?>
                <td class="adjacent" style="text-align:center;"><b>$ <?=$extendcost;?></b></td>
				<?php }else if($_GET['extendid']=='4'){ ?>
                <td class="adjacent" style="text-align:center;"><b>$ <?=$resitcost;?></b></td>
				<?php }else{ ?>
				<td class="adjacent" style="text-align:center;"><b>$ <?php echo get_order_total()?></b></td>
                <?php } ?>
			</tr>
		<?php
		}
		else{
			echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
		}
	?>
	</table>
</div></fieldset>

<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Please choose your preferred payment method</legend>
<table width="50%" border="0">
    <tr>
      <td width="5%"><input type="radio" name="radio" id="creditcard" disabled value="creditcard" onClick="this.form.action='';" /></td>
      <td width="1%">&nbsp;</td>      
      <td width="94%">Credit card</td>      
    </tr>
    <tr>
      <td><input type="radio" name="radio" id="paypal" value="paypal" disabled onClick="this.form.action='';" /></td>    
      <td>&nbsp;</td>
      <td>Paypal</td>
    </tr>
    <tr>
      <td><input type="radio" name="radio" id="telegraphic" value="telegraphic" onClick="this.form.action='<?=$link;?>';" /></td>    
      <td>&nbsp;</td>    
      <td>Bank Transfer</td>
    </tr>   
  </table>
</fieldset>

<!------Paypal Show Hide------------>
<div class="check paypal" style="display:none">
<p> Some information i want hidden (5) </p>
</div>
<!------Paypal Show Hide------------>

<p align="center">
<input type="submit" name="submit" value=" Next " onclick="return validate();" />
</p>
</form>

<?php 	echo $OUTPUT->footer();	?>
