<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	require_once($CFG->dirroot .'/lib/blocklib.php'); 
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	
	include_once ('../pagingfunction.php');

    $PAGE->set_url('/');
    $PAGE->set_course($SITE);
	
    $listusertoken = get_string('myreport');
	$myadmin = get_string('myadmin');
	$creatednewreport = get_string('creatednewreport');
	$url1=new moodle_url('/examcenter/myreport.php', array('id'=>$USER->id));  	
    $PAGE->navbar->add(ucwords(strtolower($myadmin)), $url1)->add(ucwords(strtolower($listusertoken)), $url1)->add(ucwords(strtolower($creatednewreport)), $url1);	

    $PAGE->set_pagetype('site-index');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    echo $OUTPUT->header();
?>
<script src="../js/gen_validatorv4.js" type="text/javascript"></script>
<style type="text/css">
<?php 
	include('../institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid #666666;
		border-collapse:collapse; 
	}	
</style>
<script src="../script/jquery-1.9.1.js" type="text/javascript"></script>
<link href="http://fiddle.jshell.net/css/result-light.css" type="text/css" rel="stylesheet">
<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAll () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
	}
}
//  End -->
 function clearSelected(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form1').elements.length; i++) {
		document.getElementById('form1').elements[i].checked = checked;
	}
  }
</script>

<script type="text/javascript" language="javascript">
<!-- Begin
checked = false;
function checkedAllOrg () {
	if (checked == false){checked = true;}
		for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
		document.getElementById('form2').elements[i].checked = checked;
		//document.getElementById('selectall').disabled=true;
	}
}
//  End -->
 function clearSelectedOrg(){
	if (checked == true){checked = false}
		for (var i = 0; i < document.getElementById('form2').elements.length; i++) {
		document.getElementById('form2').elements[i].checked = checked;
		//document.getElementById('unselectall').disabled=true;
	}
  }
</script>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
	 $(document).ready(function () {
		$('#id_radio1').click(function () {
		   $('#div2').hide('fast');
		   $('#div1').show('fast');
	});
	$('#id_radio2').click(function () {
		  $('#div1').hide('fast');
		  $('#div2').show('fast');
	 });
   });
</script>

<?php include('tree1.js'); ?>
<?php include('tree1.css'); ?>

<form name="formback" id="formback" action="" method="post">
	<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">
				<input type="submit" name="backbutton" id="id_defaultbutton" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/myreport.php?id='.$USER->id;?>'" value="<?=get_string('back');?>" /></td>
		</tr>    
	</table>
</form>

<form name="form1" id="form1" action="" method="post">
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler"><?=get_string('reportmenu');?></legend>
<div style="color:#F00; margin-bottom:1em;"><?//=get_string('reportdeletedsuccessfully');?></div>

<?php
	$role=mysql_query("SELECT name FROM {$CFG->prefix}role WHERE id='5'");
	$nrole=mysql_fetch_array($role);	
?>

<table width="100%" style="border:none;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-weight:bolder;" width="20%">Select Report</td>
    <td>
	<select name="selectreport" id="selectreport">
	  <!--option value="3" <?php //if($_POST['searchindividu']=='3'){ echo 'selected'; } ?>>Candidate Profile</option-->
      <option value="0" <?php if($_POST['searchindividu']=='0'){ echo 'selected'; } ?>>Candidate Performance</option>
      <option value="1" <?php if($_POST['searchindividu']=='1'){ echo 'selected'; } ?>>Course Performance</option>
      <option value="2" <?php if($_POST['searchindividu']=='2'){ echo 'selected'; } ?>>Course Statistic</option>
    </select></td>
  </tr>
  <tr>
    <td style="font-weight:bolder;">Report Name</td>
    <td><input name="reportnametext" type="text" id="reportnametext" size="40" <?php if($_POST['searchindividu']){ echo 'value="'.$_POST['reportnametext'].'"'; } ?>></td>
  </tr> 
  <tr style="vertical-align:top;">
    <td style="font-weight:bolder;">User Type</td>
    <td>
		<input id="id_radio1" type="radio" name="name_radio1" value="1" <?php if($_POST['name_radio1']=='1'){ echo 'checked'; } ?>  checked="checked" />Individual<br>
		<input id="id_radio2" type="radio" name="name_radio1" value="2" <?php if($_POST['name_radio1']=='2'){ echo 'checked'; } ?> />Organization
	</td>
  </tr> 
</table>
</fieldset><br/>

<!----For Individual---->
<div id="div1" <?php if($_POST['name_radio1']=='2'){ echo 'style="display:none"'; } ?>>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Individual</legend>
<table style="margin:1em auto 0px; padding:0px; border: 0px solid #666666; border-collapse:collapse;" width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17%" scope="row">
      <?=get_string('candidatedetails');?></td>
    <td width="0%">:</td>
    <td width="83%">
	<select name="individualitem" id="individualitem" style="width:200px;">
	  <option value="traineeid"><?=get_string('candidateid');?></option>
	  <option value="firstname"><?=get_string('firstname');?></option>
	  <option value="lastname"><?=get_string('lastname');?></option>
	  <option value="dob"><?=get_string('dateofbirth');?></option>
    </select>
	<input name="individusearch" type="text" id="individusearch" size="40" />
	<input type="submit" name="searchindividu" id="searchindividu" value="Search" />
	</td></tr> 
</table>
<!--/form-->
<?php
	if($_POST['searchindividu']){	
		$selectreport=$_POST['selectreport'];
		$reportname=$_POST['reportnametext'];
		$grouptype=$_POST['name_radio1'];
	}else{
		$selectreport=$_POST['selectreport'];
		$reportname=$_POST['reportnametext'];
		$grouptype=$_POST['name_radio1'];
	}
?>
	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="95%" border="0" cellpadding="0" cellspacing="0">
		<tr>
        	<td><?=get_string('newreportindividualnotice');?></td>
			<td align="right">
				<input type="submit" name="confirmindividual" id="confirmindividual" value="Confirm" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportmenu_action.php?id='.$USER->id.'&sreport='.$selectreport.'&nreport='.$reportname;?>'" />            
            	<input type="button" name="unselectall" id="unselectall" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectall" id="selectall" value="Select All" onClick="checkedAll()"/>
          </td>
		</tr>    
	</table>	
    
<?php
	//individu part
	$individualitem=$_POST['individualitem'];
	$individusearch=$_POST['individusearch'];	
		
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id
	";
	
	if($USER->id !='2'){
		$statement.=" WHERE c.userid!='".$USER->id."' AND d.orgtype='".$USER->orgtype."'";
	}else{
		$statement.=" WHERE c.userid!='".$USER->id."'";
	}
	if($individusearch!=''){
		if($individualitem=='dob'){
			$statement.=" AND ((date_format(from_unixtime(d.dob), '%d/%m/%Y') LIKE '%{$individusearch}%'))";
		}else{
			$statement.=" AND {$individualitem} LIKE '%{$individusearch}%'";
		}
	}
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} GROUP BY d.firstname, d.lastname, c.userid ORDER BY d.traineeid ASC";
	$sqlquery=mysql_query($csql);	
?>	
	  <table width="95%" border="1" id="searchtable" style="margin:0px auto;">
		<tr style="background-color:#ccc;">
		  <th width="15%" scope="row"><?=get_string('candidateid');?></th>
		  <th width="20%"><?=get_string('firstname');?></th>
		  <th width="20%"><?=get_string('lastname');?></th>          
		  <th width="10%"><?=get_string('dob');?></th>
		  <th width="12%"><?=get_string('organization');?></th>
          <th width="1%">&nbsp;</th>
		</tr>
<?php
	$mycount=mysql_num_rows($sqlquery);
	$no='1';
	if($mycount !='0'){
	while($sqlrow=mysql_fetch_array($sqlquery)){
	$linkto=$CFG->wwwroot. "/offlineexam/candidate_examsummary.php?id=".$sqlrow['userid']."&examid=".$sqlrow['examid'];
	$bil=$no++;
?>
		<tr>
		  <td style="text-align:center"><?=strtoupper($sqlrow['traineeid']);?></td>
		  <td><?=ucwords(strtolower($sqlrow['firstname']));?></td>
          <td><?=ucwords(strtolower($sqlrow['lastname']));?></td>
		  <td style="text-align:center"><?=date('d/m/Y' ,$sqlrow['dob']);?></td>
		  <td style="text-align:center">
		  <?php
			if($sqlrow['orgtype']!=''){ 
				$sqlor=mysql_query("
					SELECT * 
					FROM  mdl_cifaorganization_type WHERE id='".$sqlrow['orgtype']."' 				
				");
				$sql=mysql_fetch_array($sqlor);
				echo $sql['name']; 
			}else{ echo ' - '; }?>
		  </td>
          <td style="text-align:center;">
		  <?php if($_POST['searchindividu']){ ?>
			<input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['userid'];?>" />
		  <?php }else{ ?>
		  <input type="checkbox" name="checktoken[]" id="checktoken[]" value="<?=$sqlrow['userid'];?>" />
		  <?php } ?>
		  </td>
		</tr>

<?php
	}}else{
?>
		<tr><td colspan="10" scope="row">Records not found</td></tr>
<?php } ?>
		</table><br/>	  
  </fieldset>
  </div>
  <!--/form-->

  
<!----For Organization---->
<div id="div2" <?php if($_POST['name_radio1']=='1'){ echo 'style="display:none"'; }else if(($_POST['name_radio1']!='1') && ($_POST['name_radio1']!='2')){ echo 'style="display:none"'; } ?>>
<fieldset style="padding: 1em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Organization</legend>




    <link href="styles/kendo.common.min.css" rel="stylesheet" />
    <link href="styles/kendo.default.min.css" rel="stylesheet" />
    <link href="styles/kendo.dataviz.min.css" rel="stylesheet" />
    <link href="styles/kendo.dataviz.default.min.css" rel="stylesheet" />
    <script src="js/jquery.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/kendo.all.min.js"></script>
    
	<table style="padding:0px; border: 0px solid #666666; border-collapse:collapse;margin:0px auto;" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
        	<td>&nbsp;<?//=get_string('newreportorgnotice');?></td>
			<td align="right">
				<input type="submit" name="confirmindividual" id="confirmindividual" value="Confirm" onClick="this.form.action='<?=$CFG->wwwroot. '/examcenter/reportmenu_org_action.php?id='.$USER->id.'&sreport='.$selectreport.'&nreport='.$reportname;?>'" />          
            	<input type="button" name="unselectallorg" id="unselectallorg" value="Unselect All" onclick="clearSelected();" />
				<input type="button" name="selectallorg" id="selectallorg" value="Select All" onClick="checkedAll()"/>
          </td>
		</tr>    
	</table>
    
    <div id="example">
    <div class="demo-section k-header">
        <div class="box-col">
            <h4>Check nodes</h4>
            <div id="treeview"></div>
        </div>
        <div class="box-col">
            <h4>Status</h4>
            <p id="result">No nodes checked.</p>
        </div>
	<input type="hidden" name="myField" id="myField" />		
    </div>

  <?php 
	  /******/ 
	  $sqlorg=mysql_query("
			Select
			  *
			From
			  mdl_cifaorganization_type 	  
	  ");
	  $no='2';
  ?>
    <script>
        $("#treeview").kendoTreeView({
            checkboxes: {
                checkChildren: true
            },

            dataSource: [{
                id: 0, text: "Shape Financial", expanded: true, spriteCssClass: "rootfolder", items: [
					<?php
					  while($sorg=mysql_fetch_array($sqlorg)){
						  $bil=$no++;
						  $orgname=$sorg['name'];
						  $orgid=$sorg['id'];
					?>				
                    {
                        id: <?=$orgid;?>, text: "<?=$orgname;?>", expanded: false, spriteCssClass: "folder", items: [
							<?php
							  $sqlorg1=mysql_query("
								Select
								  *, b.id as userid
								From
								  mdl_cifaorganization_type a Inner Join
								  mdl_cifauser b On a.id = b.orgtype
								Where a.id='".$orgid."'
							 ");
							while($sp=mysql_fetch_array($sqlorg1)){
							  $userid=$sp['userid'];
							  if($sp['middlename']!=''){
									$user_fullname=$sp['firstname'].' '.$sp['middlename'].' '.$sp['lastname'];
							  }else{
									$user_fullname=$sp['firstname'].' '.$sp['lastname'];
							  }						
							?>
                            //{ id: <?=$userid;?>, text: "<?=ucwords(strtolower($user_fullname));?>", spriteCssClass: "html" },
							<?php } ?>
                        ]
                    },<?php } ?>
                ]
            }]
        });

        // function that gathers IDs of checked nodes
        function checkedNodeIds(nodes, checkedNodes) {
            for (var i = 0; i < nodes.length; i++) {
                if (nodes[i].checked) {
                    checkedNodes.push(nodes[i].id);
                }

                if (nodes[i].hasChildren) {
                    checkedNodeIds(nodes[i].children.view(), checkedNodes);
                }
            }
        }

        // show checked node IDs on datasource change
        $("#treeview").data("kendoTreeView").dataSource.bind("change", function() {
            var checkedNodes = [],
                treeView = $("#treeview").data("kendoTreeView"),
                message;

            checkedNodeIds(treeView.dataSource.view(), checkedNodes);

            if (checkedNodes.length > 0) {
                message = "IDs of checked nodes: " + checkedNodes.join(",");
				message2 = checkedNodes.join(",");
            } else {
                message = "No nodes checked.";
            }

            $("#result").html(message);
			document.getElementById('myField').value=message2;
        });
    </script>

    <style scoped>
        #treeview .k-sprite {
            background-image: url("coloricons-sprite.png");
        }

        .rootfolder { background-position: 0 0; }
        .folder     { background-position: 0 -16px; }
        .pdf        { background-position: 0 -32px; }
        .html       { background-position: 0 -48px; }
        .image      { background-position: 0 -64px; }
        
        .box-col { min-width: 300px;}

    </style>
</div> 
  </fieldset> </div> </form><br/>

<script  type="text/javascript">
 var frmvalidator = new Validator("form1");
 frmvalidator.addValidation("selectreport","req","Please select report");
 frmvalidator.addValidation("reportnametext","req","Please enter report name");
 frmvalidator.addValidation("reportnametext","maxlen=100",
        "Max length for FirstName is 20");
 
/*  frmvalidator.addValidation("LastName","req");
 frmvalidator.addValidation("LastName","maxlen=20");
 
 frmvalidator.addValidation("Email","maxlen=50");
 frmvalidator.addValidation("Email","req");
 frmvalidator.addValidation("Email","email");
 
 frmvalidator.addValidation("Phone","maxlen=50");
 frmvalidator.addValidation("Phone","numeric");
 
 frmvalidator.addValidation("Address","maxlen=50"); */
 frmvalidator.addValidation("name_radio1","req");
</script>
<?php 
	echo $OUTPUT->footer();
?>