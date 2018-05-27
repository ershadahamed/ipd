<?php
include('manualdbconfig.php');
if (isloggedin()) {
        add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
?>	
<style>
<?php 
	include('css/style2.css'); 
	include('css/button.css');
	include('css/pagination.css');
	include('css/grey.css');	
?>
</style>	
<?php
	if ($USER->id == '2') {
	echo $OUTPUT->heading('Mock Test & Final Test', 2, 'headingblock header');
	}else{
	echo $OUTPUT->heading(get_string('myexams'), 2, 'headingblock header');
	}
?>
<table width="98%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td>
	<?php  	
		if(($USER->id!='2') && ($USER->id !='7')){
                    //not administrator
                    $sql="SELECT * FROM {$CFG->prefix}user_enrolments a, {$CFG->prefix}enrol b";
                    $sql.=" WHERE  a.enrolid=b.id AND (a.userid='".$USER->id."' AND b.enrol='paypal')";
                    $sqlQ=mysql_query($sql);
                    $rs=mysql_num_rows($sqlQ);
                    echo '<fieldset id="fieldset">';
                    //count modules, if 10, show exam.
                    if($rs>='10'){
			include('userfrontpage/content2.php');
                    }else{
                     echo'<div style="padding-top: 20px; padding-bottom: 20px;">You need to subscribe all modules in Cifa Foundation Curiculum in order to sit for exam.</div>';
                    }
                    echo '</fieldset>';
		}elseif($USER->id =='7'){ //if exam centre admin
                    echo '<fieldset id="fieldset">';
                    include('userfrontpage/content2.php');
                    echo '</fieldset>';   
                }
                else{
			//administrator
			include_once ('pagingfunction.php');
			echo '<fieldset id="fieldset">';
			include('userfrontpage/admin-exams.php'); 
			echo '</fieldset>';
		}
	?>
	</td></tr>
</table>
<?php }else{ 
	//echo 'List of available exam';
		echo $OUTPUT->heading('List of available exam', 2, 'headingblock header');
	include('userfrontpage/availableexam.php'); 
} ?>