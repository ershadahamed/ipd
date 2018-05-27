<?php
include('config.php');
include('manualdbconfig.php'); 
include_once ('pagingfunction.php');
?>
<style>
html a,body a,html a:visited,body a:visited {
color:#333;
} 
<?php 
	include('css/style2.css'); 
	include('css/style_oter.css'); 
	include('css/button.css');
	include('css/pagination.css');
	include('css/grey.css');
?>
</style>
<?php
if (isloggedin()) {
        //add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
?>	
<div style="width:100%;">	
<table style="width: 100%; min-width: 700px; float:left; padding:0px; margin:0px;" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan="2">
	<?php 	
		if(($USER->id)!='2'){
            $queryrole  = $DB->get_records('role_assignments',array('userid'=>$USER->id));
			foreach($queryrole as $qrole){ }
			if($qrole->roleid =='3'){			//trainer frontpage
				echo html_writer::tag('a', get_string('skipa', 'access', moodle_strtolower(get_string('availablecourses'))), array('href'=>'#skipavailablecourses', 'class'=>'skip-block'));
				echo '<fieldset id="availablecourse-fieldset" style="background-color:none;">';
						include('userfrontpage/trainer-availablemodules.php');
				echo '</fieldset>';
				echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipavailablecourses'));
			}else if($qrole->roleid =='11'){	//examiner frontpage
				echo html_writer::tag('a', get_string('skipa', 'access', moodle_strtolower(get_string('availablecourses'))), array('href'=>'#skipavailablecourses', 'class'=>'skip-block'));
				echo '<fieldset id="availablecourse-fieldset" style="background-color:none;">';
						include('userfrontpage/examiner-availablemodules.php');
				echo '</fieldset>';
				echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipavailablecourses'));				
			}else if($qrole->roleid =='9'){	//inactive frontpage
				//echo html_writer::tag('a', get_string('skipa', 'access', moodle_strtolower(get_string('availablecourses'))), array('href'=>'#skipavailablecourses', 'class'=>'skip-block'));
				//echo '<fieldset id="availablecourse-fieldset" style="background-color:none;">';
						include('userfrontpage/inactivecandidate_home_page.php');
						//include('userfrontpage/frontpage-content.php');
				//echo '</fieldset>';
				//echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipavailablecourses'));							
			}else if($qrole->roleid =='10'){	//exam center admin
				include('userfrontpage/examcenter_home_page.php');
			}else if($qrole->roleid =='13'){	//Hr Admin/Instituion Client 
				include('userfrontpage/hradmin_home_page.php');
			}else if($qrole->roleid =='14'){
				include('userfrontpage/inactivehradmin_home_page.php');
			}else{
				//if users //index//home
				unset($_SESSION['cart']);
				//include('userfrontpage/frontpage-content.php');
				include('userfrontpage/candidate_home_page.php');
			}
		}else{
			//if administrator
			//index//home
			echo html_writer::tag('a', get_string('skipa', 'access', moodle_strtolower(get_string('availablecourses'))), array('href'=>'#skipavailablecourses', 'class'=>'skip-block'));
			echo '<fieldset id="availablecourse-fieldset" style="background-color:none;">';
				include('userfrontpage/admin-availablemodules.php');
			echo '</fieldset>';
			echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipavailablecourses'));
			
			
			echo html_writer::tag('a', get_string('skipa', 'access', moodle_strtolower(get_string('availablecourses'))), array('href'=>'#skipavailablecourses', 'class'=>'skip-block'));
				include('userfrontpage/usermanagementHome.php');
			echo '<br/>';
			echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipavailablecourses'));
		}
	?>
	</td>
	</tr>
</table></div>
<?php }else{ 
	//if not loggin
	include("mainpage.php");
} ?>