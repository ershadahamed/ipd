<body onLoad="window.print()">
<?php
	require_once('../config.php');
	require_once('../manualdbconfig.php');
	
	$selecteduser = $_POST['suser']; // id
?>
<style type="text/css">
<?php 
	include('../institutionalclient/style.css');
?>
	a:hover {text-decoration:underline;}
	#searchtable td, th{	 
		border: 1px solid black;
		border-collapse:collapse; 
	}	
	#searchtable th{	 
		color:#fff;
		background-color:#666;
	}	
html, body {
    font-family: Verdana,Geneva,sans-serif !important;
    color: #333;
}	
table {
    font-size: inherit;
	border-spacing: 0px;
	border: 1px solid black;
}	
img{ border:0px;}
</style>
<div style="width:98%;margin:0px auto;"><h3><?=get_string('olineexamschedulling');?></h3></div>
<!--div style="color:#2cac19; font-weight:bolder;padding:0.5em 2em;">
"<?//=get_string('olinebookexam');?>"</div-->

<table width="98%" border="1" id="searchtable" style="margin:0px auto;">
    <tr align="center" style="background-color:#ccc;">
      <th width="10%" scope="row" style="text-align:left;">
            <div style="position: relative;">
                <img src="../image/btp_c.png" style="width:100%; height:2.5em; border: 0; padding: 0" />
                <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
                <span style="position: absolute; top: 30%; margin-top: -0.6em; margin-left: 0.5em;">Candidate ID</span>
            </div>      
      </th>
      <th width="15%" style="text-align:left;">
        <div style="position: relative;">
            <img src="../image/btp_c.png" style="width:100%; height:2.5em; border: 0; padding: 0" />
            <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
            <span style="position: absolute; top: 30%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('firstname');?></span>
        </div>       
      </th>
      <th width="15%" style="text-align:left;">
        <div style="position: relative;">
            <img src="../image/btp_c.png" style="width:100%; height:2.5em; border: 0; padding: 0" />
            <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
            <span style="position: absolute; top: 30%; margin-top: -0.6em; margin-left: 0.5em;"><?=get_string('lastname');?></span>
        </div>      
      </th>
      <th width="20%" style="text-align:left;">
        <div style="position: relative;">
            <img src="../image/btp_c.png" style="width:100%; height:2.5em; border: 0; padding: 0" />
            <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
            <span style="position: absolute; top: 30%; margin-top: -0.6em; margin-left: 0.5em;">CIFA&#8482; Examination Title</span>
        </div>      
      </th>
      <th width="10%" style="text-align:left;">
        <div style="position: relative;">
            <img src="../image/btp_c.png" style="width:100%; height:2.5em; border: 0; padding: 0" />
            <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
            <span style="position: absolute; top: 30%; margin-top: -0.6em; margin-left: 0.5em;">Token Expiry</span>
        </div>       
      </th>
      <th width="10%" style="text-align:left;">
        <div style="position: relative;">
            <img src="../image/btp_c.png" style="width:100%; height:2.5em; border: 0; padding: 0" />
            <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
            <span style="position: absolute; top: 30%; margin-top: -0.6em; margin-left: 0.5em;">Exam Date</span>
        </div>       
      </th>
      <th width="10%" style="text-align:left;">
        <div style="position: relative;">
            <img src="../image/btp_c.png" style="width:100%; height:2.5em; border: 0; padding: 0" />
            <!-- Put the upper left corner of the character in the middle then move it (left+up)wards by "half" of the char width -->
            <span style="position: absolute; top: 30%; margin-top: -0.6em; margin-left: 0.5em;">Exam Time</span>
        </div>        
      </th>
    </tr>
<?php
	for($i=0; $i<sizeof($selecteduser); $i++){	
		$bookingid=$selecteduser[$i];
		$examdate=$startdatepicker[$i];
		$examtime=$datetimepicker[$i];
			
	$statement="
	  mdl_cifacourse a Inner Join
	  mdl_cifaenrol b On a.id = b.courseid Inner Join
	  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
	  mdl_cifauser d On c.userid = d.id Inner Join
	  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
	";
	
	$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate' And e.bookexam='0' And e.bookstatus='1' And e.id='".$selecteduser[$i]."' And e.centerid='".$USER->id."'";
	$csql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";

	$sqlquery=mysql_query($csql);
	while($sqlrow=mysql_fetch_array($sqlquery)){
?>
    <tr>
      <td style="text-align:center;" scope="row"><?=$sqlrow['traineeid'];?></td>
      <td><?=$sqlrow['firstname'];?></td>
      <td><?=$sqlrow['lastname'];?></td>
      <td><?=$sqlrow['fullname'];?></td>
      <td style="text-align:center;"><?=date('d/m/Y H:i:s', $sqlrow['tokenexpiry']);?></td>
      <td style="text-align:center;"><?=$sqlrow['examdate'];?></td>
      <td style="text-align:center;"><?=$sqlrow['examtime'];?></td>
    </tr>
<?php }} ?>
</table>