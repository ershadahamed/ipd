<?php
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
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
	}
	elseif ($hascustommenu) { ?>
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

	<div id="jcontrols_button">
		<div class="jcontrolsleft">		
			<?php if ($hasnavbar) { ?>
				<div class="navbar clearfix">
					<div class="breadcrumb"> <?php echo $OUTPUT->navbar();  ?></div>

				</div>
			<?php } ?>
		</div>
		<div id="ebutton">
			<?php if ($hasnavbar) { /* if($USER->id=='2'){ */ echo $PAGE->button; }/* } */ ?>
		</div>
	</div>	
	<div id="page-content">
		<div id="region-main-box">
			<div id="region-post-box">
				<div id="region-main-wrap">
					<div id="region-main">
						<div class="region-content">
						<div id="mainpadder">
						<?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
						<?php //include('content.php');?>
						</div>
						</div>
					</div>
				</div>

			<?php if ($hassidepre) { ?>
			<div id="region-pre" class="block-region">
				<div class="region-content">
					<?php echo $PAGE->pagelayout; if($USER->id=='2'){ echo $OUTPUT->blocks_for_region('side-pre'); }else{ ?>
					 <?php	
						//echo $PAGE->pagelayout;		

							 $a1.= html_writer::start_tag('div', array('id'=>'inst5','aria-labelledby'=>'instance-5-header','role'=>'navigation','class'=>'block_settings  block'));
							 $a1.= html_writer::start_tag('div', array('style'=>'background-color:#56b3c9;','class'=>'header'));
							 $a1.= html_writer::start_tag('div', array('class'=>'title'));
							 $a1.= html_writer::start_tag('h2', array('id'=>'instance-5-header'));						
						
							 $a.= html_writer::start_tag('div', array('id'=>'inst5','aria-labelledby'=>'instance-5-header','role'=>'navigation','class'=>'block_settings  block'));
							 $a.= html_writer::start_tag('div', array('class'=>'header'));
							 $a.= html_writer::start_tag('div', array('class'=>'title'));
							 $a.= html_writer::start_tag('h2', array('id'=>'instance-5-header'));
							 
							 $b.= html_writer::end_tag('h2');
							 $b.= html_writer::end_tag('div'); 
							 $b.= html_writer::end_tag('div');
							 $b.= html_writer::end_tag('div');
						
						if($PAGE->pagelayout=='mydashboard'){
							echo $a1."<b>PROFILE</b>".$b;						 	
							echo $a."PASSWORD".$b;							
							echo $a."FINANCIAL STATEMENT".$b;
							echo $a."ENROLLMENT CONFIRMATION".$b;
							echo $a."CONTINUE MY PURCHASE".$b;
							echo $a."PAYNOW".$b;
						}
						else if($PAGE->pagelayout=='standard'){
							echo $a1."<b>PROFILE</b>".$b;						 	
							echo $a."PASSWORD".$b;							
							echo $a."FINANCIAL STATEMENT".$b;
							echo $a."ENROLLMENT CONFIRMATION".$b;
							echo $a."CONTINUE MY PURCHASE".$b;
							echo $a."PAYNOW".$b;							 
						}
						else if($PAGE->pagelayout=='base'){							 
							echo $a1."<b>ACTIVE TRAININGS</b>".$b;						 	
							echo $a."EXAM RESULTS".$b;							
							echo $a."CIFAONLINE NAVIGATION ".$b;
							echo $a."CIFAONLINE POLICY".$b;							 
						}
						else if($PAGE->pagelayout=='course'){
							echo $a1."<b>Foundations Modules</b>".$b;						 	
							echo $a."Exam Guide".$b;							
							echo $a."Mock Exam".$b;
							echo $a."Evaluation".$b;							 
						}												
					 ?>						 
				</div>
			</div>
			<?php }} ?>

			<?php if ($hassidepost) { ?>
			<div id="region-post" class="block-region">
				<div class="region-content">
					<?php echo $PAGE->pagelayout; echo $OUTPUT->blocks_for_region('side-post') ?>				
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
<div id="themeorigin">&nbsp;<!--a href="http://moodle.org/plugins/view.php?plugin=theme_aardvark">Original theme created by Shaun Daubney</a>  |  <a href="http://moodle.org">moodle.org</a--></div>
</div>
 
 <?php } ?>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>