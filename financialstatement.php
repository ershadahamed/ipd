<?php
	require_once('config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('manualdbconfig.php');
	
    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $financialtext = get_string('financialstatement');
    $PAGE->navbar->add(ucwords(strtolower($financialtext)));	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();	
?>
<style type="text/css">
<?php 
	include('institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid #666666;
		border-collapse:collapse; 
	}	
	
	#searchtable th{	 
		background-color: #cccccc;
	}		
</style>
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('financialstatement');?></legend>

<form name="form" id="form" action="" method="post">
<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td scope="row">Candidate Detail</td>
    <td width="2%">:</td>
    <td>
	<select name="candidatedetails" id="candidatedetails" style="width:200px;">
      <option value="traineeid">Candidate ID</option>
      <option value="firstname">First Name</option>
      <option value="lastname">Last Name</option>
    </select>
	<input type="text" style="width:300px;" name="candidatedetails_s" id="candidatedetails_s" />
	<input type="submit" name="button" id="button" value="Search" />
	</td></tr> 
</table>
<?php 
	$candidatedetails=$_POST['candidatedetails']; 
	if($_POST['candidatedetails'] == 'dob'){
		echo $candidatedetails_s=strtotime($_POST['candidatedetails_s']); 
	}else{
		$candidatedetails_s=$_POST['candidatedetails_s'];	
	}
	
	$role=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
	$nrole=mysql_fetch_array($role);
	
	//to get list of financial
	$statement = mysql_query("
		Select
		  c.userid,
		  d.traineeid,
		  d.firstname,
		  d.lastname,
		  b.cost,
		  a.fullname
		From
		  mdl_cifacourse a Inner Join
		  mdl_cifaenrol b On b.courseid = a.id Inner Join
		  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
		  mdl_cifauser d On c.userid = d.id
		Where
		  b.enrol = 'manual' And
		  d.usertype = '".$nrole['name']."' And
		  a.category = '1'
	");
	
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On b.courseid = a.id Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id	
	";
	
	$statement.=" WHERE b.enrol = 'manual' And d.usertype = '".$nrole['name']."' And a.category = '1'";
	if($candidatedetails_s!=''){
		$statement.=" AND {$candidatedetails} LIKE '%{$candidatedetails_s}%'";
	}
	$csql="SELECT c.userid, d.traineeid, d.firstname, d.lastname, b.cost, a.fullname FROM {$statement} ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);		
?>
</form>
<form id="form1" name="form1" method="post" action="">
  <table id="searchtable" style="margin:1em auto 0px;" width="95%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <th><strong>No</strong></th>
	  <th align="center"><strong>Date</strong></th>
      <th align="center"><strong>Candidate ID</strong></th>
      <th><strong>Full Name</strong></th>
      <th><strong>Course Name </strong></th>
      <th align="center"><strong>Fee Entitlement</strong></th>
      <th align="center"><strong>Payment Status</strong></th>
	  <!--th align="center"><strong>View</strong></th-->
    </tr>
<?php
	$bil='1';
	$frowcol=mysql_num_rows($sqlquery);
	if($frowcol!='0'){
	while($financial=mysql_fetch_array($sqlquery)){
?>    
    <tr>
      <td style="text-align:center;" scope="row"><?=$bil++;?></td>
	  <td style="text-align:center;">
		<?php
			$sql=mysql_query("
				Select
				  b.paystatus,
				  b.date
				From
				  mdl_cifacandidates a Inner Join
				  mdl_cifaorders b On a.serial = b.customerid Inner Join
				  mdl_cifaorder_detail c On b.serial = c.orderid
				Where
					a.candidateid='".$financial['userid']."'
			");
			$sqlarray=mysql_fetch_array($sql);
			echo date('d/m/Y', $sqlarray['date']);
		?>	  
	  </td>
      <td style="text-align:center;"><?=strtoupper($financial['traineeid']);?></td>
      <td><?=$financial['firstname'].' '.$financial['lastname'];?></td>
      <td><?=$financial['fullname'];?></td>
      <td style="text-align:center;"><?=$financial['cost'];?></td>
      <td style="text-align:center;">
		<?php
			echo strtoupper($sqlarray['paystatus']);
		?>	  
	  </td>
	  <!--td></td-->
    </tr>
<?php }}else{ ?>    
    <tr>
      <td scope="row">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
<?php } ?>
  </table><br/>
</form>
  </fieldset>
<form name="formback" id="formback" action="" method="post">
	<table style="text-align:center; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td>
				<input type="submit" name="backbutton" id="backbutton" onClick="this.form.action='<?=$CFG->wwwroot. '/index.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" /></td>
		</tr>    
	</table>
</form>  
<?php echo $OUTPUT->footer(); ?>
