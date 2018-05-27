<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.hovertable {
	font-family: verdana,arial,sans-serif;
	font-size:13px;
	color:#333333;
	border-collapse: collapse;
	/* width:100%; */
	margin-left: 40px;
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

#main-logo-sm {
	margin-left:0px;
	width:147px;
}

</style>
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
<!--- step by step----->
<style>
#shopcart img{max-width:80%;}
</style>
<table id="shopcart" width="80%" border="0" style="text-align:left;">
	<tr>
	<td><img src="image/step1_select_program.png" width="80%"></td>   
	</tr>
</table>

<!-- Table goes in the document BODY -->
<table id="avalaiblecourse" style="width:100%; float:left;" border="0" cellpadding="0" cellspacing="0"><tr valign="top">
<td style="width:75%;">

  <?php	
	$extendcost='50'; 	//cost for extend course
	$resitcost='50';	//cost for re-sit exam
	  
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
		  b.status = '0' And a.id!='63'
	";				  
    if($search!=''){$sqlCourses.=" And (a.fullname LIKE '%".$search."%' Or a.shortname LIKE '%".$search."%')";} 
    $sqlCourses.=" Order By a.id ASC";
    $queryCourses=mysql_query($sqlCourses);
    $count=mysql_num_rows($queryCourses);

    if($count>0){

    while($rowCourses=mysql_fetch_array($queryCourses)){
	$sqlC=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE userid='".$USER->id."' AND enrolid='".$rowCourses['enrolid']."'");
	$rowC=mysql_num_rows($sqlC); //untuk cek user ni ada enrol course atau x
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
		}
	} 
	
	?>  
	
	<?php if($rowC != '0'){ // ada logo purchase ?>
	<div id="main-logo-sm">
		<a href="#"><img src="image/purchased_logo_grey.png" alt="CIFA" style="width:147px;"></a>
	</div><!-- #main-logo-sm -->
	<?php }?>
	
	<?php if($rowC != '0'){ // ada logo purchase ?>
	<table style="width:95%; margin-top:4em; margin-left:3em;" class="hovertable" cellpadding="0" cellspacing="0" border="0">
	<?php }else{ ?>
	<table class="hovertable" cellpadding="0" cellspacing="0" border="0">
	<?php } ?>
	
	<tr style="font-size:15px;background-color: #21409A;color:#fff;">
		<?php if($rowC != '0'){ // ada logo purchase ?>
			<td style="padding-left:7em;"><b><?=$rowCourses['idnumber'].': '.$rowCourses['fullname'];?></b></td>
			<td style="width:20%;text-align:right;"><b><i>$ <?=$rowCourses['cost'];?></li></b></td>
		<?php }else{ ?>
			<td><b><?=$rowCourses['idnumber'].': '.$rowCourses['fullname'];?></b></td>
			<td style="width:20%;text-align:right;"><b><i>$ <?=$rowCourses['cost'];?></li></b></td>		
		<?php }?>
	</tr>
	<tr>
		<td class="adjacent" style="vertical-align:top;" colspan="2">		
		<div class="col-md-3" style="width:98%;">
			<div class="widget-app">
				<div class="widget-app-header-purchase">
				</div><!-- .widget-app-header -->
				<div class="widget-app-body">
					<div class="post-list margin-md-top" style="min-height:0px;">
						<div class="post">
							<div class="excerpt" <?php if($rowC != '0'){ ?> style="margin-top:3.5em;" <?php } ?>>
								<?=$rowCourses['summary'];?>
							</div><br/><!-- .excerpt -->
							<div class="date" style="text-align:center;">			
							
							<?php 
								$printtxt = $CFG->wwwroot. "/userfrontpage/view_course_details.php?id=".$rowCourses['courseid'];
								//courses details PDF
								if($rowCourses['courseid']=='32'){
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD01.php?id=".$rowCourses['courseid'];
								}else if($rowCourses['courseid']=='34'){
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD02.php?id=".$rowCourses['courseid'];
								}else if($rowCourses['courseid']=='37'){ 
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD03.php?id=".$rowCourses['courseid'];
								}else if($rowCourses['courseid']=='58'){
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD04.php?id=".$rowCourses['courseid'];
								}else if($rowCourses['courseid']=='38'){ 
									$course_details = $CFG->wwwroot. "/courses_synopsis_pdf/IPD05.php?id=".$rowCourses['courseid'];
								}
								
								if($rowCourses['courseid']=='59'){
							?>	
								
							<input type="image" src="image/view_course_details.png" name="view_course_details" onclick="window.open('<?=$printtxt;?>', 'Window2', 'status = 1, width=880, height=500, resizable = yes, scrollbars=1');" onMouseOver="style.cursor='pointer'" title="View Course Details" width="133px">
							<?php }else{ ?>
							<!--a href="<?=$course_details;?>" target="_blank"><img src="image/view_course_details.png" name="view_course_details" onMouseOver="style.cursor='pointer'" title="View Course Details" width="133px" /></a-->
							<a href="#" onclick="window.open('<?=$course_details;?>', 'Window2', 'width=820,height=600,resizable = 1,scrollbars=1');"><img src="image/view_course_details.png" name="view_course_details" onMouseOver="style.cursor='pointer'" title="View Course Details" width="133px" /></a>
							<?php } ?>
																
								<?php if($rowC == '0'){ if($sqlgot['paystatus']==$statuspending){ ?>
								<input type="image" src="image/buy_now.png" name="buy_now" onclick='alert(&quot;You already subscribe this module <?=ucwords(strtoupper($rowCourses['shortname']));?> and status still <?=ucwords(strtoupper($sqlgot['paystatus']));?>.\nPlease proceed with your payment OR Please contact administrator for more information.&quot;)' title="Buy Now" width="80" >
								<?php }else{ ?>
								<input type="image" src="image/buy_now.png" name="buy_now" onclick="addtocart(<?=$rowCourses['courseid'];?>)" title="Buy Now" width="80" >
								<?php }} ?>
							</div>
						</div><!-- .post -->
					</div><!-- .post-list -->
				</div><!-- .widget-app-body -->
			</div><!-- .widget-app -->
		</div>		
		</td>
	</tr></table>
	<?php 
	/* } */  //not found search records.
	}
	}else{ echo "No records found.";} 

	if($kirarow == $count){ echo "<h3>All course has been subscribe.</h3>";} 
?>
</td>
<?php if($kirarow != $count){ ?>
<td>
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
	
	<?php // if($kirarow != $count){ ?>
	<table style="width:100%; background-color:#fff; border:1.8px solid #3D91CB;" >
		<tr><td style="background-color: #6d6e70;color:#ffffff;font-weight:bolder;"><b>Shopping Cart<b></td></tr>
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
				<tr><td><?=$q;?></td><td> X </td><td><?=$pname;?><br/>
				<?php
					if($_GET['resitexamid']=='3'){
						echo get_string('extension');
					}else if($_GET['resitexamid']=='4'){
						echo get_string('re_sit');
					}
				?>				
				</td>
				<td style="width:23%; vertical-align:top;">
				<?php
					if($_GET['resitexamid']=='3'){
						echo '$ '.$extendcost;
					}else if($_GET['resitexamid']=='4'){
						echo '$ '.$resitcost;
					}else{
						echo '$ '.get_price($pid);
					}
				?>				
				<?//=get_price($pid);?>
				</td>
				</tr>
				<?php } ?>

			<tr><td colspan="2">&nbsp;</td><td><b>Order Total</b></td><td style="text-align:center;background-color: yellow"><b>
			<?php
				if($_GET['resitexamid']=='3'){
					echo '$ '.$extendcost;
				}else if($_GET['resitexamid']=='4'){
					echo '$ '.$resitcost;
				}else{
					echo '$ '.get_order_total();
				}
			?>
			</b></td></tr>
			<tr><td colspan="2">&nbsp;</td><td><b>Items in cart</b></td><td style="text-align:center;background-color: yellow"><b><?=$i;?></b></td></tr>
		</table>
		<div style="text-align:center;" id="cartsbutton">
			<input class="clearcartbutton" type="button" style="cursor:pointer;" onclick="clear_cart()" name="clearcart" value="Clear Cart">
			
        	<?php if($_GET['resitexamid']=='3'){ ?>
            <input class="proceedbutton" type="button" style="cursor:pointer;" name="clearcart" value="Proceed" title="Proceed to next step" onclick="window.location='<?=$CFG->wwwroot;?>/portal/subscribe/paydetails_loggeduser_extend.php?pid=<?=$pid;?>&resitexamid=3'" >              
            <?php } else if($_GET['resitexamid']=='4'){ ?>
           <input class="proceedbutton" type="button" style="cursor:pointer;" name="clearcart" value="Proceed" title="Proceed to next step" onclick="window.location='<?=$CFG->wwwroot;?>/portal/subscribe/paydetails_loggeduser_extend.php?pid=<?=$pid;?>&resitexamid=4'" >              
			<?php }else{ ?>
            <input class="proceedbutton" type="button" style="cursor:pointer;" name="clearcart" value="Proceed" title="Proceed to next step" onclick="window.location='<?=$CFG->wwwroot;?>/portal/subscribe/paydetails_loggeduser.php?pid=<?=$pid;?>'" >            
            <?php
				}
			?>    		
		</div>
		</td></tr>
	<?php }else{?>
			<tr bgColor="#FFFFFF"><td class="adjacent">There are no items in your shopping cart!</td></tr>
	<?php		} ?>
	</table><table style="background-color:#fff; border:1.8px solid #3D91CB;"><tr><td style="text-align:justify;"><?=get_string('logoutnotice');?></td></tr></table>
	<?php // } ?>
	</td>
	<?php } ?>
	</tr></table>	




