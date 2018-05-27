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

<table style="margin-bottom: 0px;" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td>
	<?php 
		if(($USER->id)!='2'){ 
			//if not administrator    
				
			if($sqlrow>='2'){ //jika bil. lebih dari 1
			//echo '<fieldset style="padding: 0.6em;" id="user" class="clearfix">';
			if($cIPD!='0'){ /*SHAPE IPD*/ 
				echo '<h1 class="title enroll-color">'.get_string('ipdcourses').'</h1>';
				// echo '<legend style="font-weight:bolder;" class="ftoggler">'.get_string('ipdcourses').'</legend>';
			}else{
				// echo '<legend style="font-weight:bolder;" class="ftoggler">'.get_string('cifacurriculum').'</legend>';
				echo '<h1 class="title enroll-color">'.get_string('cifacurriculum').'</h1>';
			}	
				include('userfrontpage/content1.php');
				//echo '</fieldset>';
			}else if(($sqlrow=='1')){
				//echo '<fieldset style="padding: 0.6em;" id="user" class="clearfix">';
                //echo '<legend style="font-weight:bolder;" class="ftoggler">'.get_string('ipdcourses').'</legend>';
				echo '<h1 class="title enroll-color">'.get_string('ipdcourses').'</h1>';
				include('userfrontpage/content1.php');
                //echo '</fieldset>';
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
	//echo $OUTPUT->heading(get_string('enrollnow'), 2, 'headingblock header');
	
	//session control for 15minutes
	include('js/js_idletime.php'); 
?>
<?php
 $sqlCourses="
		Select
		  *,
		  b.id As enrolid,
		  a.id As viewid
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
table.hovertable {
	font-family: verdana,arial,sans-serif;
	font-size:13px;
	color:#333333;
	border-collapse: collapse;
	width:100%;
	border: 1px #21409A solid;
}
table.hovertable th {
	background-color:#6d6e70;
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #21409A;
	color:#ffffff;
}
table.hovertable tr {
	/*background-color:#d4e3e5;*/
}
table.hovertable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #21409A;
}
#shopcart img{max-width:80%;}
</style>
<table id="shopcart" width="80%" border="0" style="text-align:left;">
	<tr>
	<td><img src="image/step1_select_program.png" width="80%"></td>   
	</tr>
</table>
<table width="100%"><tr valign="top"><td width="78%">

<?php while($rowCourses=mysql_fetch_array($queryCourses)){ ?>
<table class="hovertable"  width="100%">
	<tr style="font-size:18px;background-color: #21409A;color:#fff;">
			<td><b><?=$rowCourses['idnumber'].': '.$rowCourses['fullname'];?></b></td>
			<td style="width:20%;text-align:right;"><b><i>$ <?=$rowCourses['cost'];?></li></b></td>		
	</tr>
<tr>
	<td class="adjacent" style="vertical-align:top;" colspan="2">
	<div class="col-md-3" style="width:98%;padding:5px;">
		<div class="widget-app">
			<div class="widget-app-header-purchase">
			</div><!-- .widget-app-header -->
			<div class="widget-app-body">
				<div class="post-list margin-md-top" style="min-height:0px;">
					<div class="post">
						<div class="excerpt"><br/>
							<?=$rowCourses['summary'];?>
						</div><br/><!-- .excerpt -->
						<div class="date" style="text-align:center;">

							<?php 
								$printtxt = $CFG->wwwroot. "/userfrontpage/view_course_details.php?id=".$rowCourses['courseid'];
								$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/view_course_details.php?id=".$rowCourses['courseid'];
								
								//courses details PDF
								/* if($rowCourses['courseid']=='32'){
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD01.php?id=".$rowCourses['courseid'];
								}else if($rowCourses['courseid']=='34'){
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD02.php?id=".$rowCourses['courseid'];
								}else if($rowCourses['courseid']=='37'){ 
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD03.php?id=".$rowCourses['courseid'];
								}else if($rowCourses['courseid']=='58'){
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD04.php?id=".$rowCourses['courseid'];
								}else if($rowCourses['courseid']=='38'){ 
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD05.php?id=".$rowCourses['courseid'];
								} */
								
								/* if($rowCourses['courseid']=='59'){
							?>	
								
							<input type="image" src="image/view_course_details.png" name="view_course_details" onclick="window.open('<?=$printtxt;?>', 'Window2', 'status = 1, width=880, height=500, resizable = yes, scrollbars=1');" onMouseOver="style.cursor='pointer'" title="View Course Details" width="133px">
							<?php }else{ */ ?>							
							<a href="#" onclick="window.open('<?=$course_details;?>', 'Window2', 'width=820,height=600,resizable = 1,scrollbars=1');"><img src="image/view_course_details.png" name="view_course_details" onMouseOver="style.cursor='pointer'" title="View Course Details" width="133px" /></a>
							<?php //} ?>
							<input type="image" src="image/buy_now.png" name="buy_now" onclick="addtocart(<?=$rowCourses['courseid'];?>)" title="Buy Now" width="80" >
						</div>
					</div><!-- .post -->
				</div><!-- .post-list -->
			</div><!-- .widget-app-body -->
		</div><!-- .widget-app -->
	</div>		
	</td>
</tr></table>
<?php } ?>




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
	<table style="width:100%; background-color:#fff; border:1.8px solid #3D91CB;" >
		<tr><td style="background-color: #ccc"><b>Shopping Cart<b></td></tr>
		<?php if(is_array($_SESSION['cart'])){ ?>
		<tr><td>
		<table id="availablecourse3" width="100%">			
			<?php 
			$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				$pid=$_SESSION['cart'][$i]['productid'];
				$q=$_SESSION['cart'][$i]['qty'];
				$pname=get_product_name($pid);
				if($q==0) continue;?>
				<tr><td><?=$q;?></td><td> X </td><td><?=$pname;?></td><td style="width:25%; vertical-align:top;"> $ <?=get_price($pid);?></td></tr>
				<?php } ?>

			<tr><td colspan="2">&nbsp;</td><td><b>Order Total</b></td><td style="text-align:center;background-color: yellow"><b>$ <?=get_order_total();?></b></td></tr>
			<tr><td colspan="2">&nbsp;</td><td><b>Items in cart</b></td><td style="text-align:center;background-color: yellow"><b><?=$i;?></b></td></tr>
		</table>
		<?php if($max>0){ ?>
		<!--div style="text-align:center;">
			<img style="cursor:pointer;" onclick="clear_cart()" src="image/clear_cart.png" width="80" title="Clear cart"/>
			<img style="cursor:pointer;" onclick="window.location='<?//=$CFG->wwwroot;?>/billing.php?pid=<?//=$pid;?>'" src="image/proceed_button.png" width="80" title="Proceed to next step"/>
		</div-->
		<div style="text-align:center;" id="cartsbutton">
			<input class="clearcartbutton" type="button" style="cursor:pointer;" onclick="clear_cart()" name="clearcart" value="Clear Cart">
			<input class="proceedbutton" type="button" style="cursor:pointer;" name="clearcart" value="Proceed" title="Proceed to next step" onclick="window.location='<?=$CFG->wwwroot;?>/billing.php?pid=<?=$pid;?>'" >
			<!--img style="cursor:pointer;" onclick="clear_cart()" src="image/clear_cart.png" width="80" title="Clear cart"/>
			<img style="cursor:pointer;" onclick="window.location='<?//=$CFG->wwwroot;?>/portal/subscribe/paydetails_loggeduser.php?pid=<?//=$pid;?>'" src="image/proceed_button.png" width="80" title="Proceed to next step"/-->		
		</div>		
		<?php } ?>
		</td></tr><?php }else{ ?>
		<tr><td>There are no items in your shopping cart!</td></tr>
		<?php } ?>
	</table>
	<table style="background-color:#fff; border:1.8px solid #3D91CB;"><tr><td style="text-align:justify;"><?=get_string('logoutnotice');?></td></tr></table>
</td></tr></table>

<?php	
	//include('userfrontpage/reg-availablecourse.php'); 
 } ?>