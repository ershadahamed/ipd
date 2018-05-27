<?php
include('../manualdbconfig.php');
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
if(($PAGE->pagelayout!='frontpage') && ($PAGE->pagelayout!='buy_a_cifa')){ 
	$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
}else{
	if($USER->id == '2'){
		$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
	}else{
		//$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
	}
}
if($PAGE->pagelayout=='incourse'){
		$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
}
//$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$showsidepre = $hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT);
$showsidepost = $hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT);

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));
$haslogo = (!empty($PAGE->theme->settings->logo));
$hasceop = (!empty($PAGE->theme->settings->ceop));
$hasdisclaimer = (!empty($PAGE->theme->settings->disclaimer));
$hasemailurl = (!empty($PAGE->theme->settings->emailurl));
$hasprofilebarcustom = (!empty($PAGE->theme->settings->profilebarcustom));
$hasfacebook = (!empty($PAGE->theme->settings->facebook));
$hastwitter = (!empty($PAGE->theme->settings->twitter));
$hasgoogleplus = (!empty($PAGE->theme->settings->googleplus));
$hasflickr = (!empty($PAGE->theme->settings->flickr));
$haspicasa = (!empty($PAGE->theme->settings->picasa));
$hastumblr = (!empty($PAGE->theme->settings->tumblr));
$hasblogger = (!empty($PAGE->theme->settings->blogger));
$haslinkedin = (!empty($PAGE->theme->settings->linkedin));
$hasyoutube = (!empty($PAGE->theme->settings->youtube));
$hasvimeo = (!empty($PAGE->theme->settings->vimeo));


$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<?php if (isloggedin()) { ?>

<script type="text/javascript">
inactivityTimeout = False
resetTimeout()
function onUserInactivity() {
   //window.location.href = "onUserInactivity.php"
   window.location.href = "<?=$CFG->wwwroot;?>/login/logout.php?sesskey=<?=sesskey();?>"
   alert('You have been idle for 15 minutes. System will logout automatically.');   
}
function resetTimeout() {
   clearTimeout(inactivityTimeout)
   inactivityTimeout = setTimeout(onUserInactivity, 1000 * 900)
}
window.onmousemove = resetTimeout
</script>
<?php } ?>
<?php /*if (!isloggedin()) { ?> 
<div id="menuwrap">
<div id="menuwrap960">
<div id="homeicon">
<a href="<?php echo $CFG->wwwroot; ?>" class="homeiconlink">
	<?php if ($haslogo) {	?>          
         <!--img src="<?php //echo $PAGE->theme->settings->logo;?>" /-->
		 <img src="<?php echo $OUTPUT->pix_url('logo', 'theme')?>" />  
         <?php       } 
                 else { ?>
                <img src="<?php echo $OUTPUT->pix_url('logo', 'theme')?>" />         
         <?php  } ?>
</a>
</div>
	<?php 
	if (!isloggedin()) {
	}elseif ($hascustommenu) { ?>
 		<div id="menuitemswrap"><div id="custommenu"><?php echo $custommenu; ?></div></div>
	<?php } ?>
    <?php include('profileblock.php')?>
</div></div> <?php } */?>
	
<?php 
/* if (isloggedin()) { */ include('header_custom.php'); /* } */?>	
<div id="page-header"></div>
<div id="contentwrapper">	
	<!-- start OF moodle CONTENT -->        
	<div id="page-title">
	<div id="page-title-inner"><?php //if($USER->id!='2'){ echo 'Welcome to CIFAOnline!'; }else{ echo $PAGE->title; }?>
	</div></div>
	
	<?php if($PAGE->pagelayout!='frontpage'){ ?>
	<div id="jcontrols_button">
		<div class="jcontrolsleft">		
			<?php if ($hasnavbar) { ?>
				<div class="navbar clearfix">
					<div class="breadcrumb"> 
						<?php 
							echo $OUTPUT->navbar(); 
						?>
					</div>

				</div>
			<?php } ?>
		</div> 
		<div id="ebutton">
			<?php 
				if ($hasnavbar) { 
				
				$role=mysql_query("
					Select
					  b.userid,
					  a.name,
					  b.roleid,
					  b.contextid
					From
					  mdl_cifarole a Inner Join
					  mdl_cifarole_assignments b On a.id = b.roleid Inner Join
					  mdl_cifauser c On b.userid = c.id
					Where
					  b.contextid='1' And b.userid='".$USER->id."' And
					  (b.roleid='10' Or b.roleid='4' Or b.roleid='3' Or b.roleid='15')
				");
				$roleaccepetance=mysql_num_rows($role); 
								
				if($USER->id=='2'){ echo $PAGE->button; } 				
				if($roleaccepetance=='1'){ echo $PAGE->button; }
				} 
			?>
		</div>
	</div>	
	<?php }else{ echo '<br/>'; } ?>
	<div id="page-content" style="min-height:300px;">
		<div id="region-main-box">
			<div id="region-post-box">
				<div id="region-main-wrap">
					<div id="region-main">
						<div class="region-content">
						<div id="mainpadder">
						<?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
						</div>
						</div>
					</div>
				</div>

			<?php if ($hassidepre) { ?>
			<div id="region-pre" class="block-region">
				<div class="region-content"  style="margin-right:0.8em;">
					<?php if($USER->id=='2'){ 
							/* echo $PAGE->pagelayout; */
							echo $OUTPUT->blocks_for_region('side-pre');
							}else{ ?>
					 <?php	
						//echo $PAGE->pagelayout;
						
							//echo '<div style="margin-top:0.8em;margin-right:0.8em;"><div>';
							$rolesql=mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE contextid='1' AND userid='".$USER->id."'");
							$rs=mysql_fetch_array($rolesql);
							
							 $a1.= html_writer::start_tag('div', array('id'=>'inst5','aria-labelledby'=>'instance-5-header','role'=>'navigation','class'=>'block_settings  block'));
							 $a1.= html_writer::start_tag('div', array('style'=>'background-color:#56b3c9;','class'=>'header'));
							 $a1.= html_writer::start_tag('div', array('class'=>'title', 'style'=>'padding: 5px 5px 0 10px;'));
							 $a1.= html_writer::start_tag('h2', array('id'=>'instance-5-header'));						
						
							 $a.= html_writer::start_tag('div', array('id'=>'inst5','aria-labelledby'=>'instance-5-header','role'=>'navigation','class'=>'block_settings  block'));
							 $a.= html_writer::start_tag('div', array('class'=>'header'));
							 $a.= html_writer::start_tag('div', array('class'=>'title', 'style'=>'color:#fff;padding: 5px 5px 0 10px;'));
							 $a.= html_writer::start_tag('h2', array('id'=>'instance-5-header'));
							 
							 $b.= html_writer::end_tag('h2');
							 $b.= html_writer::end_tag('div'); 
							 $b.= html_writer::end_tag('div');
							 $b.= html_writer::end_tag('div');
							 
							$aa=$CFG->wwwroot.'/user/profile.php?id='.$USER->id;
							$ab=$CFG->wwwroot.'/login/change_password.php?id=1';	
							$ac=$CFG->wwwroot. '/userfrontpage/viewuserresult.php?id='.$USER->id;
							$ad=$CFG->wwwroot. '/SHAPEpolicy.pdf';
							$ae=$CFG->wwwroot. '/coursesindex.php?id='.$USER->id;
							$af=$CFG->wwwroot. '/course/view.php?id='.$COURSE->id;
							$af2=$CFG->wwwroot. '/course/view.php?id='.$_GET['id'];
							$link_reactive=$CFG->wwwroot. '/purchasemodule.php?id='.$USER->id;
							$link_enrolment=$CFG->wwwroot. '/userfrontpage/listofnameenrolment.php';
							$examguide=$CFG->wwwroot .'/course/examguide.php?id='.$COURSE->id;
							$evaluation=$CFG->wwwroot .'/mod/feedback/complete.php?id=205&courseid=&gopage=0';
							
							$policy=$CFG->wwwroot .'/userpolicy.php';
							
							$urleditpicture = $CFG->wwwroot. '/user/edit_picture.php?id='.$USER->id.'&course=1';
							
							$ac_open="<a href='".$ac."' class='button' title='".get_string('examresult')."'>";
							$onclickpolicy="window.open('".$policy."', 'Window2', 'width=820,height=600,resizable = 1,scrollbars=1');";
							$ad_open='<a href="#" class="button" title="CIFAOnline Policy" onclick="'.$onclickpolicy.'">';					
							
							$ae_open="<a href='".$ae."' class='button' title='Active Trainings'>";
							$af_open="<a href='".$af."' class='button' title=''>";
							$af2_open="<a href='".$af2."' class='button' title=''>";
							$enrolment_open="<a href='".$link_enrolment."' class='button' title='Enrollment Confirmation'>";
							$reactive_open="<a href='".$link_reactive."' class='button' title='Reactive Now'>";
							$eg_open="<a href='".$examguide."' class='button' title='Exam Guide'>";
							$ev_open="<a href='".$evaluation."' class='button' title='Evaluation'>";
							$a_close="</a>";
							
							$titleprofile='<b>PROFILE</b>';
							$titlepassword='<b>PASSWORD</b>';
							$titlefinancial='<b>FINANCIAL STATEMENT</b>';
							$titleenrolconfirm='<b>ENROLLMENT CONFIRMATION</b>';
							$titlecmp='<b>CONTINUE MY PURCHASE</b>';
							$titlepaynow='<b>PAY NOW</b>';
							$titlereactive='<b>REACTIVATE</b>';
							
							$titlect='<b>ACTIVE TRAININGS</b>';
							$titleer='<b>EXAM RESULTS</b>';
							$titlecn='<span style="margin-bottom:1em;"><b>CIFAOnline NAVIGATION</b></span>';
							$titlecp='<b>CIFAOnline POLICY</b>';
							$titleeg='<b>EXAM GUIDE</b>';
							$titleme='<b>MOCK EXAM</b>';
							$titlesoft=get_string('titlesoft');
							$titleevaluation='<b>EVALUATION</b>';
							$moduletitle='<b>MODULE</b>';
							$spacewhite='<div style="padding-bottom:1em;"></div>';
							
							$sql=mysql_query("
								Select
									  a.section,
									  a.course,
									  a.summary
									From
									  mdl_cifacourse_sections a
									Where
									  a.section = '0' And
									  a.course = '".$COURSE->id."'
							");
							$sqlexamguide=mysql_fetch_array($sql);
							$sqlcount=mysql_num_rows($sqlexamguide);							
													
						if($PAGE->pagelayout=='mydashboard'){
							echo '<br/>'.$a1."<b><a href='".$aa."' class='button'>".$titleprofile."</a></b>".'<div style="padding-bottom:1em;"></div>'.$b;
							echo '<br/>'.$a."<a href='".$ab."' class='button'>".$titlepassword."</a>".'<div style="padding-bottom:1em;"></div>'.$b;								
							echo '<br/>'.$a.$titlefinancial.$spacewhite.$b;
							
							if(($rs['roleid']=='10') || ($rs['roleid']=='12') || ($rs['roleid']=='13')){
								echo '<br/>'.$a.$titlecn.$spacewhite.$b;
							}else{
								echo '<br/>'.$a.$enrolment_open.$titleenrolconfirm.'<div style="padding-bottom:1em;"></div>'.$a_close.$b;
								echo '<br/>'.$a.$titlecmp.'<div style="padding-bottom:1em;"></div>'.$b;
								echo '<br/>'.$a.$titlepaynow.'<div style="padding-bottom:1em;"></div>'.$b;
								echo '<br/>'.$a.$reactive_open.$titlereactive.$a_close.'<div style="padding-bottom:1em;"></div>'.$b;
							}
						}
						else if($PAGE->pagelayout=='standard'){
							echo '<br/>'.$a1."<b><a href='".$aa."' class='button'>".$titleprofile.'</a></b><div style="padding-bottom:1em;"></div>'.$b;
							echo '<br/>'.$a."<a href='".$ab."' class='button'>".$titlepassword.'</a><div style="padding-bottom:1em;"></div>'.$b;							
							echo '<br/>'.$a.$titlefinancial.'<div style="padding-bottom:1em;"></div>'.$b;
							if(($rs['roleid']=='10') || ($rs['roleid']=='12') || ($rs['roleid']=='13')){
								echo '<br/>'.$a.$titlecn.$spacewhite.$b;
							}else{
								echo '<br/>'.$a.$enrolment_open.$titleenrolconfirm.'<div style="padding-bottom:1em;"></div>'.$a_close.$b;
								echo '<br/>'.$a.$titlecmp.'<div style="padding-bottom:1em;"></div>'.$b;
								echo '<br/>'.$a.$titlepaynow.'<div style="padding-bottom:1em;"></div>'.$b;	
							}
						}
						else if($PAGE->pagelayout=='edit_picture'){
							echo '<br/>'.$a1."<b><a href='".$aa."' class='button'>".$titleprofile.'</a></b><div style="padding-bottom:1em;"></div>'.$b;
							echo '<br/>'.$a."<a href='".$ab."' class='button'>".$titlepassword.'</a><div style="padding-bottom:1em;"></div>'.$b;							
							echo '<br/>'.$a.$titlefinancial.'<div style="padding-bottom:1em;"></div>'.$b;
							echo '<br/>'.$a.$enrolment_open.$titleenrolconfirm.'<div style="padding-bottom:1em;"></div>'.$a_close.$b;
							echo '<br/>'.$a.$titlecmp.'<div style="padding-bottom:1em;"></div>'.$b;
							echo '<br/>'.$a.$titlepaynow.'<div style="padding-bottom:1em;"></div>'.$b;							
						}
						else if($PAGE->pagelayout=='change_password'){ 							
							echo '<br/>'.$a."<a href='".$aa."' class='button'>".$titleprofile."</a>".$spacewhite.$b;
							echo '<br/>'.$a1."<b><a href='".$ab."' class='button'>".$titlepassword."</a></b>".$spacewhite.$b;				
							echo '<br/>'.$a.$titlefinancial.'<div style="padding-bottom:1em;"></div>'.$b;
							// echo '<br/>'.$a.$enrolment_open.$titleenrolconfirm.'<div style="padding-bottom:1em;"></div>'.$a_close.$b;
							// echo '<br/>'.$a.$titlecmp.'<div style="padding-bottom:1em;"></div>'.$b;
							// echo '<br/>'.$a.$titlepaynow.'<div style="padding-bottom:1em;"></div>'.$b;	
							if(($rs['roleid']=='10') || ($rs['roleid']=='12') || ($rs['roleid']=='13')){
								echo '<br/>'.$a.$titlecn.$spacewhite.$b;
							}else{
								echo '<br/>'.$a.$enrolment_open.$titleenrolconfirm.'<div style="padding-bottom:1em;"></div>'.$a_close.$b;
								echo '<br/>'.$a.$titlecmp.'<div style="padding-bottom:1em;"></div>'.$b;
								echo '<br/>'.$a.$titlepaynow.'<div style="padding-bottom:1em;"></div>'.$b;
								echo '<br/>'.$a.$reactive_open.$titlereactive.$a_close.'<div style="padding-bottom:1em;"></div>'.$b;
							}							
						}	
						else if($PAGE->pagelayout=='enrollment'){ 							
							echo '<br/>'.$a."<a href='".$aa."' class='button'>".$titleprofile."</a>".$spacewhite.$b;
							echo '<br/>'.$a."<a href='".$ab."' class='button'>".$titlepassword."</a>".$spacewhite.$b;				
							echo '<br/>'.$a.$titlefinancial.'<div style="padding-bottom:1em;"></div>'.$b;
							echo '<br/>'.$a1.$enrolment_open."<b>".$titleenrolconfirm.'<div style="padding-bottom:1em;"></div>'."</b>".$a_close.$b;
							echo '<br/>'.$a.$titlecmp.'<div style="padding-bottom:1em;"></div>'.$b;
							echo '<br/>'.$a.$titlepaynow.'<div style="padding-bottom:1em;"></div>'.$b;							 
						}						
						else if($PAGE->pagelayout=='base'){	
							if(($rs['roleid']=='10') || ($rs['roleid']=='12') || ($rs['roleid']=='13')){
								echo '<br/>'.$a1.$ae_open."<b>".$titlect."</b>".$a_close.$spacewhite.$b;						 	
								echo '<br/>'.$a.$ac_open.$titleer.$a_close.'<div style="padding-bottom:1em;"></div>'.$b;							
								echo '<br/>'.$a.$titlecn.'<div style="padding-bottom:1em;"></div>'.$b;
								echo '<br/>'.$a.$ad_open.$titlecp.$a_close.'<div style="padding-bottom:1em;"></div>'.$b;	
							}else{
								echo '<br/>'.$a1."<b>".$titlesoft."</b>".$spacewhite.$b;
							}							
						}
						else if($PAGE->pagelayout=='exam_result'){				 
							echo '<br/>'.$a.$ae_open.$titlect.$a_close.'<div style="padding-bottom:1em;"></div>'.$b;						 	
							echo '<br/>'.$a1.$ac_open."<b>".$titleer."</b>".$a_close.'<div style="padding-bottom:1em;"></div>'.$b;							
							echo '<br/>'.$a.$titlecn.'<div style="padding-bottom:1em;"></div>'.$b;
							echo '<br/>'.$a.$ad_open.$titlecp.$a_close.'<div style="padding-bottom:1em;"></div>'.$b;							
						}						
						else if($PAGE->pagelayout=='course'){
							$query_mock=mysql_query("
								Select
								  *, b.id as setquizid
								From
								  mdl_cifaquiz a Inner Join
								  mdl_cifacourse_modules b On a.course = b.course And a.id = b.instance	
								Where
								  a.course='".$COURSE->id."'
							");
							
							$c_mock=mysql_num_rows($query_mock);
							$s_mock=mysql_fetch_array($query_mock);							
						
							$mock_link='<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$s_mock['setquizid'].'">';
							$m_close='</a>';
							
							echo '<br/>'.$a1.$af_open."<b>".$moduletitle."</b>".$spacewhite.$a_close.$b;							 	
							if($sqlcount!='0'){ echo '<br/>'.$a.$eg_open.$titleeg.$a_close.$spacewhite.$b; }else{ echo $a.$titleeg.$spacewhite.$b;}
							if($c_mock!='0'){
								echo '<br/>'.$a.$mock_link.$titleme.$m_close.'<div style="padding-bottom:1em;"></div>'.$b;
							}else{
								echo '<br/>'.$a.$titleme.'<div style="padding-bottom:1em;"></div>'.$b;
							}
							echo '<br/>'.$a.$ev_open.$titleevaluation.$a_close.'<div style="padding-bottom:1em;"></div>'.$b;							 
						}	
						else if($PAGE->pagelayout=='incourse_layer1'){ 						
							echo '<br/>'.$a.$af_open.$moduletitle.$a_close.$spacewhite.$b;							 	
							if($sqlcount!='0'){ echo '<br/>'.$a.$eg_open.$titleeg.$a_close.$spacewhite.$b; }else{ echo $a.$titleeg.$spacewhite.$b;}							
							echo '<br/>'.$a1."<b>".$titleme."</b>".$spacewhite.$b;
							echo '<br/>'.$a.$ev_open.$titleevaluation.$a_close.$spacewhite.$b;												 
						}

						else if($PAGE->pagelayout=='examguide'){   //Exam Guide Layout
							$query_mock=mysql_query("
								Select
								  *, b.id as setquizid
								From
								  mdl_cifaquiz a Inner Join
								  mdl_cifacourse_modules b On a.course = b.course And a.id = b.instance	
								Where
								  a.course='".$_GET['id']."'
							");
							
							$c_mock=mysql_num_rows($query_mock);
							$s_mock=mysql_fetch_array($query_mock);	

							$queryeg=mysql_query("SELECT fullname FROM {$CFG->prefix}course WHERE id='".$_GET['id']."'");
							$roweg=mysql_fetch_array($queryeg);			
						
							$mock_link='<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$s_mock['setquizid'].'">';
							$m_close='</a>';
							
							echo $a.$af2_open.$moduletitle.$a_close.$spacewhite.$b;
							echo $a1."<b>".$titleeg."</b>".$spacewhite.$b;
							//if($sqlcount!='0'){ echo $a1.$eg_open."<b>".$titleeg."</b>".$a_close.$b; }else{ echo $a.$titleeg.$b;}
							if($c_mock!='0'){ echo $a.$mock_link.$titleme.$m_close.$spacewhite.$b; }else{ echo $a.$titleme.$spacewhite.$b; }
							echo $a.$titleevaluation.$spacewhite.$b;							 
						}
						
						}											
					 ?>						 
				</div>
			</div>
			<?php } ?>

			<?php if ($hassidepost) { ?>
			<div id="region-post" class="block-region">
				<div class="region-content">				
					<?php 
						/* echo $PAGE->pagelayout; */  /* if($PAGE->pagelayout!='frontpage'){ */ if($USER->id =='2'){ echo $OUTPUT->blocks_for_region('side-post'); }  /* } */
						
						 $a.= html_writer::start_tag('div', array('id'=>'inst5','aria-labelledby'=>'instance-5-header','role'=>'navigation','class'=>'block_settings  block'));
						 $a.= html_writer::start_tag('div', array('class'=>'header'));
						 $a.= html_writer::start_tag('div', array('class'=>'title'));
						 $a.= html_writer::start_tag('h2', array('id'=>'instance-5-header'));
						 $a2.= html_writer::start_tag('ul', array('style'=>'list-style-image:url("sqpurple.gif");'));
						 $a2.= html_writer::start_tag('li');
						 
						 $b2.= html_writer::end_tag('li');
						 $b2.= html_writer::end_tag('ul');
						 $b.= html_writer::end_tag('h2');
						 $b.= html_writer::end_tag('div'); 
						 $b.= html_writer::end_tag('div');
						 $b.= html_writer::end_tag('div');
						
						/* Admin Setting block (link) */
						$aa=$CFG->wwwroot. '/admin/roles/assign.php?contextid=1';
						$aa_open="<a href='".$aa."' class='button'>";
						$ab=$CFG->wwwroot. '/userfrontpage/admin-commpreference.php';
						$ab_open="<a href='".$ab."' class='button'>";
						$ac=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;
						$ac_open="<a href='".$ac."' class='button'>";
						$ad=$CFG->wwwroot.'/config/uploadconfig.php';
						$ad_open="<a href='".$ad."' class='button'>";
						
						$aemailac=$CFG->wwwroot.'/manualemail/emailactivity.php';
						$aemailac_open="<a href='".$aemailac."' class='button'>";
						$aecc=$CFG->wwwroot.'/manualemail/emailcontent_config.php';
						$aecc_open="<a href='".$aecc."' class='button'>";
						$av=$CFG->wwwroot.'/course/view.php?id=57'; //feedback//evaluation
						$av_open="<a href='".$av."' class='button'>";
						$air=$CFG->wwwroot.'/financialinstituition/list_ofregistration_admin.php'; 
						$air_open="<a href='".$air."' class='button'>";
						
						$aemail=$CFG->wwwroot.'/manualemail/manualsend_email.php';
						$aemail_open="<a href='".$aemail."' class='button'>";
						
						$anews=$CFG->wwwroot.'/news_update/list_ofnews_update.php';
						$anews_open="<a href='".$anews."' class='button'>";
						$ae=$CFG->wwwroot. '/userfrontpage/prospectstatus.php?id='.$USER->id;
						$ae_open="<a href='".$ae."' class='button'>";
						$af=$CFG->wwwroot.'/userfrontpage/resetpassword.php';
						$af_open="<a href='".$af."' class='button'>";
						$ag=$CFG->wwwroot. '/transaction_status.php?id='.$USER->id;
						$ag_open="<a href='".$ag."' class='button'>";
						$ah=$CFG->wwwroot.'/userfrontpage/updatecandidate_details.php';
						$ah_open="<a href='".$ah."' class='button'>";
						$ap=$CFG->wwwroot. '/progress_report.php?id='.$USER->id;
						
						/* Report block (link) */
						$ai=$CFG->wwwroot. '/progress_report.php?id='.$USER->id;
						$ai_open="<a href='".$ap."' class='button'>";
						$aj=$CFG->wwwroot.'/course/report/log/index.php?id=1';
						$aj_open="<a href='".$aj."' class='button'>";
						$ak=$CFG->wwwroot.'/report/transaction_report.php';
						$ak_open="<a href='".$ak."' class='button'>";
						$al=$CFG->wwwroot.'/report/report_1.php';
						$al_open="<a href='".$al."' class='button'>";						
						$a_close="</a>";
						
						if($PAGE->pagelayout=='frontpage'){							
							echo $a."SITE ADMINISTRATION".$b; /* Admin Setting block */
							echo $a2.$aa_open.get_string('assignusersroles').$a_close.$b2;
							echo $a2.$ab_open.get_string('communicationpreferences').$a_close.$b2;
							echo $a2.$ac_open.get_string('examresult').$a_close.$b2;
							echo $a2.$aemailac_open.get_string('emailactivity').$a_close.$b2;
							echo $a2.$aecc_open.get_string('emailcontentconfig').$a_close.$b2;
							echo $a2.$av_open.'Feedback'.$a_close.$b2;
							echo $a2.$aemail_open.get_string('manualemailconfig').$a_close.$b2;
							
							echo $a2.$anews_open.get_string('news_update').$a_close.$b2;
							echo $a2.$ad_open.'Permission to Upload'.$a_close.$b2;
							echo $a2.$ae_open.get_string('prospect').$a_close.$b2;
							echo $a2.$af_open.get_string('resetpassword').$a_close.$b2;
							echo $a2.$air_open.get_string('instregistration').$a_close.$b2;
							echo $a2.$ag_open.get_string('transactionstatus').$a_close.$b2;
							echo $a2.$ah_open.get_string('updatecandidateinfo').$a_close.$b2;													
							echo "<br/>";
							
							echo $a."REPORT".$b; /* Report block */
							echo $a2.$ai_open.get_string('candidateprogress').$a_close.$b2;
							echo $a2.$aj_open.get_string('activitylog').$a_close.$b2;
							echo $a2.$ak_open.get_string('transactionreport').$a_close.$b2;
							echo $a2.$al_open.get_string('report').$a_close.$b2;
							echo "<br/>";
						}						
					?>				
				</div>				
			</div>
			<?php } ?>
			</div>
		</div>
	</div>
	<!-- END OF CONTENT --> 
</div>      

<br style="clear: both;"> 
<div id="page-footer"></div>
 <?php if ($hasfooter) { ?>
<div id="footerwrapper">
<?php include('footer_custom.php');?>
<!--div id="footerinner"><?php //include('footer.php');?></div-->
<div id="themeorigin">&nbsp;</div>
</div>
 
 <?php } ?>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>