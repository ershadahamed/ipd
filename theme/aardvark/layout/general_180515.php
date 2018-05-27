<?php
include('../manualdbconfig.php');
global $DB, $CFG, $PAGE, $OUTPUT;
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
if (($PAGE->pagelayout != 'frontpage') && ($PAGE->pagelayout != 'buy_a_cifa') && ($PAGE->pagelayout != 'update_details')) {
    $hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
} else {
    if ($USER->id == '2') {
        if (($PAGE->pagelayout != 'buy_a_cifa')) {
            $hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
        }
    } else {
        //$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
    }
}
if ($PAGE->pagelayout == 'incourse') {
    if ($USER->id == '2') {
        $hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
    }
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

echo $OUTPUT->doctype()
?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
    <head>
        <title><?php echo $PAGE->title ?></title>
        <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme') ?>" />
<?php echo $OUTPUT->standard_head_html() ?>
    </head>
    <body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses . ' ' . join(' ', $bodyclasses)) ?>">
        <?php echo $OUTPUT->standard_top_of_body_html() ?>
        <?php
        if (isloggedin()) {
            $idletime = get_string('idletime');
            ?>

            <script type="text/javascript">
                inactivityTimeout = False
                resetTimeout()
                function onUserInactivity() {
                    //window.location.href = "onUserInactivity.php"
                    window.location.href = "<?= $CFG->wwwroot; ?>/login/logout.php?sesskey=<?= sesskey(); ?>"
                    alert('<?= $idletime; ?>');
                }
                function resetTimeout() {
                    clearTimeout(inactivityTimeout)
                    inactivityTimeout = setTimeout(onUserInactivity, 1000 * 900)
                }
                window.onmousemove = resetTimeout
            </script>
                <?php } ?><div id="setdisplay"><div style="height:93%;">

                <?php /* if (isloggedin()) { */ include('header_custom.php'); /* } */ ?>	
                <?php
                // Page Header (REQUIRED)

                echo html_writer::start_tag('div', array('id' => 'page-header'));
                echo html_writer::end_tag('div');
                ?>
                <div id="contentwrapper">	
                    <!-- start OF moodle CONTENT -->        
                    <div id="page-title">
                        <div id="page-title-inner"><?php //if($USER->id!='2'){ echo 'Welcome to CIFAOnline!'; }else{ echo $PAGE->title; }   ?>
                        </div></div>

                            <?php if ($PAGE->pagelayout != 'frontpage') { ?>
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

                                    $role = mysql_query("
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
					  b.contextid='1' And b.userid='" . $USER->id . "' And
					  (b.roleid='10' Or b.roleid='4' Or b.roleid='3' Or b.roleid='15' Or b.roleid='11')
				");
                                    $roleaccepetance = mysql_num_rows($role);

                                    if ($USER->id == '2') {
                                        echo $PAGE->button;
                                    }
                                    if ($roleaccepetance == '1') {
                                        echo $PAGE->button;
                                    }
                                }
                                ?>
                            </div>
                        </div>	
                        <?php
                    } else {
                        echo '<br/>';
                    }
                    ?>
                    <div id="page-content">
                        <!--div id="page-content" style="min-height:348px;"-->
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
                                        <div class="region-content">
                                            <?php
                                            if ($USER->id == '2') {
                                                // echo $PAGE->pagelayout; 
                                                echo $OUTPUT->blocks_for_region('side-pre');
                                            } else {
                                                // echo $PAGE->pagelayout;
                                                //echo '<div style="margin-top:0.8em;margin-right:0.8em;"><div>';
                                                $rolesql = mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE contextid='1' AND userid='" . $USER->id . "'");
                                                $rs = mysql_fetch_array($rolesql);
                                                // echo $rs['roleid'];

                                                $a1.= html_writer::start_tag('div', array('id' => 'inst5', 'aria-labelledby' => 'instance-5-header', 'role' => 'navigation', 'class' => 'block_settings  block'));
                                                //$a1.= html_writer::start_tag('div', array('style' => 'background-color:#21409A;', 'class' => 'header'));
                                                //$a1.= html_writer::start_tag('div', array('class' => 'title'));
                                                //if (($PAGE->pagelayout == 'course') || ($PAGE->pagelayout == 'examguide')) {
                                                    //$a1.= html_writer::start_tag('h2', array('id' => 'instance-5-header', 'style' => 'color:#fff;padding: 1.9em 4.3em 1.4em'));
                                                ///} else {
                                                    //$a1.= html_writer::start_tag('h2', array('id' => 'instance-5-header', 'style' => 'color:#fff;padding: 1.9em 0.9em 1.4em'));
                                                ///}

                                                $a.= html_writer::start_tag('div', array('id' => 'inst5', 'aria-labelledby' => 'instance-5-header', 'role' => 'navigation', 'class' => 'block_settings  block'));
                                                //$a.= html_writer::start_tag('div', array('class' => 'header'));
                                                //$a.= html_writer::start_tag('div', array('class' => 'title'));
                                                //if (($PAGE->pagelayout == 'course') || ($PAGE->pagelayout == 'examguide')) {
                                                    //$a.= html_writer::start_tag('h2', array('id' => 'instance-5-header', 'style' => 'color:#fff;padding: 1.9em 4.3em 1.4em'));
                                                //} else {
                                                    // $a.= html_writer::start_tag('h2', array('id' => 'instance-5-header', 'style' => 'color:#fff;padding: 1.9em 0.9em 1.4em'));
                                                //}

                                                //$b.= html_writer::end_tag('h2');
                                                //$b.= html_writer::end_tag('div');
                                                //$b.= html_writer::end_tag('div');
                                                $b.= html_writer::end_tag('div');

                                                // link
                                                // $ipddemolink=$CFG->wwwroot. '/';
                                                $aa = $CFG->wwwroot . '/user/profile.php?id=' . $USER->id;
                                                $ab = $CFG->wwwroot . '/login/change_password.php?id=1';
                                                $ac = $CFG->wwwroot . '/userfrontpage/viewuserresult.php?id=' . $USER->id;
                                                $ad = $CFG->wwwroot . '/SHAPEpolicy.pdf';
                                                $ae = $CFG->wwwroot . '/coursesindex.php?id=' . $USER->id;
                                                $af = $CFG->wwwroot . '/course/view.php?id=' . $COURSE->id;

                                                $af2 = $CFG->wwwroot . '/course/view.php?id=' . $_GET['id'];
                                                $link_reactive = $CFG->wwwroot . '/purchasemodule.php?id=' . $USER->id;
                                                $link_enrolment = $CFG->wwwroot . '/userfrontpage/listofnameenrolment.php';
                                                $examguide = $CFG->wwwroot . '/course/examguide.php?id=' . $COURSE->id;
                                                $evaluation = $CFG->wwwroot . '/mod/feedback/complete.php?id=205&courseid=&gopage=0';
                                                $linkcoursesetting = $CFG->wwwroot . '/course/edit.php?id=' . $COURSE->id;
                                                $financiallink = $CFG->wwwroot . '/financialstatement/candidateview.php?id=' . $USER->id;
                                                $ccm = $CFG->wwwroot . '/candidatemanagement/cifacandidatemanagement.php?id=' . $USER->id;
                                                $policy = $CFG->wwwroot . '/userpolicy.php';
                                                $urleditpicture = $CFG->wwwroot . '/user/edit_picture.php?id=' . $USER->id . '&course=1';
                                                
                                                $condition = ($PAGE->pagelayout == 'enrollment' || $PAGE->pagelayout == 'base');
                                                $conditionexam_result = ($PAGE->pagelayout == 'exam_result');
                                                $conditioncourse = ($PAGE->pagelayout == 'course');
                                                if ($condition){ $class="class='sideblockbar'"; }else{ $class= "class='sidebarnoimage'"; }
                                                if ($conditionexam_result){ $class1="class='sideblockbar'"; }else{ $class1= "class='sidebarnoimage'"; }
                                                if ($conditioncourse){ $class2="class='sideblockbar'"; }else{ $class2= "class='sidebarnoimage'"; }
                                                
                                                $ac_open = "<a href='" . $ac . "' ".$class1." title='" . get_string('examresult') . "'>";
                                                $onclickpolicy = "window.open('" . $policy . "', 'Window2', 'width=820,height=600,resizable = 1,scrollbars=1');";
                                                $ad_open = '<a href="#" class="sidebarnoimage" title="CIFAOnline Policy" onclick="' . $onclickpolicy . '">';

                                                $ae_open = "<a href='" . $ae . "' ".$class." title='".get_string('activetrainings')."'>";
                                                $af_open = "<a href='" . $af . "' ".$class2." title=''>";
                                                $aftest_open = "<a href='" . $ae . "' ".$class." title=''>";
                                                $af2_open = "<a href='" . $af2 . "' class='sidebarnoimage' title=''>";                        
                                                $enrolment_open = "<a href='" . $link_enrolment . "' ".$class." title='Enrollment Confirmation'>";
                                                $reactive_open = "<a href='" . $link_reactive . "' class='sidebarnoimage' title='Reactive Now'>";
                                                $eg_open = "<a href='" . $examguide . "' class='sidebarnoimage' title='Exam Guide'>";
                                                $ev_open = "<a href='" . $evaluation . "' class='sidebarnoimage' title='Evaluation'>";
                                                $coursesetting = "<a href='" . $linkcoursesetting . "' class='sidebarnoimage' title='Course Setting'>";
                                                $flink = "<a href='" . $financiallink . "' class='sidebarnoimage' title='Financial Statement'>";
                                                $a_close = "</a>";

                                                $titleprofile = get_string('profile');
                                                $candidate_management = get_string('ccmanagement');
                                                $titlepassword = get_string('password');
                                                $titlefinancial = get_string('financialstatement');
                                                $titleenrolconfirm = get_string('enrollconfirmation');
                                                $titlecmp = "<a href='#' class='sidebarnoimage'>".get_string('continuemypurchases')."</a>";
                                                $titlepaynow = "<a href='#' class='sidebarnoimage'>".get_string('paynow')."</a>";
                                                $titlereactive = '<b>REACTIVATE</b>';

                                                $titlect = get_string('activetrainings'); 
                                                $titleer = get_string('testresult');
                                                // $a="<a title='".get_string('viewdemo')."' href='javascript:void(0);'>";
                                                $titlecn = get_string('ipddemo');
                                                $titlecp = get_string('cifaonlinepolicy');
                                                $titleeg = get_string('eguide');
                                                $titleme = get_string('finaltest');
                                                $titlemocktest = get_string('mocktest');
                                                $titlesoft = get_string('titlesoft');
                                                $titleevaluation = get_string('evaluation');
                                                $moduletitle = get_string('adminmodules');

                                                $editcoursesetting = get_string('editsettings');
                                                $topspacewhite = '<div style="padding-bottom:10px;"></div>';
                                                $bottomspacewhite = '<div style="padding-bottom:5px;"></div>';
                                                // $coursepaddingmenu='<div style="padding-left:10em;"></div>';

                                                /*$sql = mysql_query("
								Select
									  a.section,
									  a.course,
									  a.summary
									From
									  mdl_cifacourse_sections a
									Where
									  a.section = '0' And
									  a.course = '" . $COURSE->id . "'
							");
                                                $sqlexamguide = mysql_fetch_array($sql);
                                                $sqlcount = mysql_num_rows($sqlexamguide);*/

                                                if ($PAGE->pagelayout == 'mydashboard') {
                                                    echo $topspacewhite . $a1 . "<a href='" . $aa . "' class='sideblockbar'>" . $titleprofile . "</a>" . $b;
                                                    echo $a . "<a href='" . $ab . "' class='sidebarnoimage'>" . $titlepassword . "</a>" . $b;
                                                    if (($rs['roleid'] == '10') || ($rs['roleid'] == '12') || ($rs['roleid'] == '13')) {
                                                        echo $a . "<a href='#' class='sidebarnoimage'>".$titlecn ."</a>". $b;
                                                    } else {
                                                        echo $a . $flink . $titlefinancial . $spacewhite . $a_close . $b;
                                                        echo $a . $enrolment_open . $titleenrolconfirm . $a_close . $b;
                                                        echo $a . $titlecmp . $b;
                                                        echo $a . $titlepaynow . $b;
                                                        // echo '<br/>'.$a.$reactive_open.$titlereactive.$a_close.$b; //this button for inactive
                                                    }
                                                } else if ($PAGE->pagelayout == 'standard') {
                                                    echo $topspacewhite . $a1 . "<a href='" . $aa . "' class='sideblockbar'>" . $titleprofile . '</a>' . $b;
                                                    echo $bottomspacewhite . $a . "<a href='" . $ab . "' class='sidebarnoimage'>" . $titlepassword . '</a>' . $b;
                                                    if (($rs['roleid'] == '10') || ($rs['roleid'] == '12') || ($rs['roleid'] == '13')) {
                                                        echo $a . "<a href='#' class='sidebarnoimage'>".$titlecn ."</a>". $b;
                                                    } else {
                                                        echo $a . $flink . $titlefinancial . $a_close . $b;
                                                        echo $a . $enrolment_open . $titleenrolconfirm . $a_close . $b;
                                                        echo $a . $titlecmp . $b;
                                                        echo $a . $titlepaynow . $b;
                                                    }
                                                } else if ($PAGE->pagelayout == 'update_details') {  //UPDATE DETAILS							
                                                    echo $topspacewhite . $a1 . "<a title='" . get_string('ccmanagement') . "' href='" . $ccm . "' class='sideblockbar'>" . $candidate_management . '</a>' . $b;
                                                    echo $a . "<a href='" . $ab . "' class='sidebarnoimage'>" . $titlepassword . '</a>' . $b;
                                                    if (($rs['roleid'] == '10') || ($rs['roleid'] == '12') || ($rs['roleid'] == '13')) {
                                                        echo $a . "<a href='#' class='sidebarnoimage'>".$titlecn ."</a>". $b;
                                                    } else {
                                                        echo $a . $flink . $titlefinancial . $a_close . $b;
                                                        echo $a . $enrolment_open . $titleenrolconfirm . $a_close . $b;
                                                        echo $a . $titlecmp . $b;
                                                        echo $a . $titlepaynow . $b;
                                                    }
                                                } else if ($PAGE->pagelayout == 'edit_picture') {
                                                    echo $topspacewhite . $a1 . "<a href='" . $aa . "' class='sideblockbar'>" . $titleprofile . '</a>' . $b;
                                                    echo $a . "<a href='" . $ab . "' class='sidebarnoimage'>" . $titlepassword . '</a>' . $b;
                                                    if (($rs['roleid'] != '10') || ($rs['roleid'] != '12') || ($rs['roleid'] != '13')) {
                                                        //echo $bottomspacewhite.$a.$flink.$titlefinancial.$a_close.$b;
                                                    } else {
                                                        echo $a . $flink . $titlefinancial . $a_close . $b;
                                                        echo $a . $enrolment_open . $titleenrolconfirm . $a_close . $b;
                                                        echo $a . $titlecmp . $b;
                                                        echo $a . $titlepaynow . $b;
                                                    }
                                                } else if ($PAGE->pagelayout == 'change_password') {
                                                    echo $topspacewhite . $a . "<a href='" . $aa . "' class='sidebarnoimage'>" . $titleprofile . "</a>" . $b;
                                                    echo $a1 . "<a href='" . $ab . "' class='sideblockbar'>" . $titlepassword . "</a>" . $b;	
                                                    if (($rs['roleid'] == '10') || ($rs['roleid'] == '12') || ($rs['roleid'] == '13')) {
                                                        echo $a . "<a href='#' class='sidebarnoimage'>".$titlecn ."</a>". $b;
                                                    } else {
                                                        echo $a . $flink . $titlefinancial . $a_close . $b;
                                                        echo $a . $enrolment_open . $titleenrolconfirm . $a_close . $b;
                                                    }
                                                } else if ($PAGE->pagelayout == 'enrollment') {
                                                    echo $topspacewhite . $a . "<a href='" . $aa . "' class='sidebarnoimage'>" . $titleprofile . "</a>" . $b;
                                                    echo $a . "<a href='" . $ab . "' class='sidebarnoimage'>" . $titlepassword . "</a>" . $b;
                                                    echo $a . $flink . $titlefinancial . $a_close . $b;
                                                    echo $a1 . $enrolment_open . $titleenrolconfirm . $a_close . $b;
                                                    // echo '<br/>'.$a.$titlecmp.$b;
                                                    // echo '<br/>'.$a.$titlepaynow.$b;							 
                                                } else if ($PAGE->pagelayout == 'base') {
                                                    if (($rs['roleid'] != '10') || ($rs['roleid'] == '12') || ($rs['roleid'] == '13')) {
                                                        echo $topspacewhite . $a1 . $ae_open . $titlect . $a_close . $b;
                                                        echo $a . $ac_open . $titleer . $a_close . $b;
                                                        echo $a . "<a href='#' class='sidebarnoimage'>".$titlecn ."</a>". $b;
                                                        echo $a . $ad_open . $titlecp . $a_close . $b;
                                                    } else {
                                                        echo $a1 . $titlesoft . $b;
                                                    }
                                                } else if ($PAGE->pagelayout == 'exam_result') {
                                                    echo $topspacewhite . $a . $ae_open . $titlect . $a_close . $b;
                                                    echo $a1 . $ac_open . $titleer . $a_close . $b;
                                                    echo $a . "<a href='#' class='sidebarnoimage'>".$titlecn ."</a>". $b;
                                                    echo $a . $ad_open . $titlecp . $a_close . $b;
                                                } else if ($PAGE->pagelayout == 'course') {     // COURSE
                                                    $mocktest_link = '<a class="sidebarnoimage" href="' . $CFG->wwwroot . '/course/mock_test.php?id=' . $USER->id . '">';
                                                    $mock_link = '<a class="sidebarnoimage" href="' . $CFG->wwwroot . '/course/finaltest.php?id=' . $USER->id . '">';
                                                    $m_close = '</a>';

                                                    echo $topspacewhite . $a1 . $af_open . $moduletitle . $a_close . $b;
                                                    // if($sqlcount!='0'){ echo $bottomspacewhite.$a.$eg_open.$titleeg.$a_close.$b; }else{ echo $bottomspacewhite.$a.$titleeg.$b;}
                                                    echo $a . $mocktest_link . $titlemocktest . $m_close . $b;
                                                    echo $a . $mock_link . $titleme . $m_close . $b;
                                                    echo $a . $ev_open . $titleevaluation . $a_close . $b;
                                                    if ($rs['roleid'] == '3') { //courses settings for trainer
                                                        echo $a . $coursesetting . $editcoursesetting . $a_close . $b;
                                                    } else if ($rs['roleid'] == '11') { //courses settings for trainer
                                                        echo $a . $coursesetting . $editcoursesetting . $a_close . $b;
                                                    }
                                                } else if ($PAGE->pagelayout == 'admin') {  //courses settings menu for trainer					
                                                    $mocktest_link = '<a class="sidebarnoimage" href="' . $CFG->wwwroot . '/course/mock_test.php?id=' . $USER->id . '">';
                                                    $mock_link = '<a class="sidebarnoimage" href="' . $CFG->wwwroot . '/course/finaltest.php?id=' . $USER->id . '">';
                                                    $m_close = '</a>';

                                                    echo $a . $aftest_open . "<b>" . $moduletitle . "</b>" . $a_close . $b;
                                                    // if($sqlcount!='0'){ echo $topspacewhite.$a.$eg_open.$titleeg.$a_close.$b; }else{ echo $topspacewhite.$a.$titleeg.$b;}
                                                    echo $a . $mocktest_link . $titlemocktest . $m_close . $b;
                                                    echo $a . $mock_link . $titleme . $m_close . $b;
                                                    echo $a . $ev_open . $titleevaluation . $a_close . $b;
                                                    if ($rs['roleid'] == '3') { //courses settings for trainer
                                                        echo $a1 . $coursesetting . $editcoursesetting . $a_close . $b;
                                                    } else if ($rs['roleid'] == '11') { //courses settings for trainer
                                                        echo $a1 . $coursesetting . $editcoursesetting . $a_close . $b;
                                                    }
                                                } else if ($PAGE->pagelayout == 'incourse_layer1') {
                                                    $mocktest_link = '<a class="sidebarnoimage" href="' . $CFG->wwwroot . '/course/mock_test.php?id=' . $USER->id . '">';
                                                    $mock_link = '<a class="sidebarnoimage" href="' . $CFG->wwwroot . '/course/finaltest.php?id=' . $USER->id . '">';
                                                    $m_close = '</a>';
                                                    echo $topspacewhite . $a . $aftest_open . $moduletitle . $a_close . $b;
                                                    if ($COURSE->category != '9') {
                                                        echo $a . $mocktest_link . $titlemocktest . $m_close . $b;
                                                        echo $a1 . "<a href='#' class='sideblockbar'>". $titleme ."</a>". $b;
                                                    } else {
                                                        echo $a1 . "<a href='#' class='sideblockbar'>". $titlemocktest ."</a>". $b;
                                                        echo $a . $mock_link . $titleme . $m_close . $b;
                                                    }
                                                    echo $bottomspacewhite . $a . $ev_open . $titleevaluation . $a_close . $b;
                                                } else if ($PAGE->pagelayout == 'examguide') {   //Exam Guide Layout
                                                    $mocktest_link = '<a class="sidebarnoimage" href="' . $CFG->wwwroot . '/course/mock_test.php?id=' . $USER->id . '">';
                                                    $mock_link = '<a class="sidebarnoimage" href="' . $CFG->wwwroot . '/course/finaltest.php?id=' . $USER->id . '">';
                                                    $m_close = '</a>';

                                                    echo $a . $af2_open . $moduletitle . $a_close . $b;
                                                    // echo $topspacewhite.$a1."<b>".$titleeg."</b>".$b;
                                                    echo $a . $mocktest_link . $titlemocktest . $m_close . $b;
                                                    echo $a . $mock_link . $titleme . $m_close . $b;
                                                    echo $a . $ev_open . $titleevaluation . $a_close . $b;
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
                                            /* echo $PAGE->pagelayout; */ /* if($PAGE->pagelayout!='frontpage'){ */ if ($USER->id == '2') {
                                                if ($PAGE->pagelayout != 'buy_a_cifa') {
                                                    echo $OUTPUT->blocks_for_region('side-post');
                                                }
                                            } /* } */

                                            if ($PAGE->pagelayout == 'incourse') {
                                                if ($COURSE->id != '57') { //survey form block
                                                    echo $OUTPUT->blocks_for_region('side-post');
                                                }
                                            }

                                            $a.= html_writer::start_tag('div', array('id' => 'inst5', 'aria-labelledby' => 'instance-5-header', 'role' => 'navigation', 'class' => 'block_settings  block'));
                                            $a.= html_writer::start_tag('div', array('class' => 'header'));
                                            $a.= html_writer::start_tag('div', array('class' => 'title'));
                                            $a.= html_writer::start_tag('h2', array('id' => 'instance-5-header'));
                                            $a2.= html_writer::start_tag('ul', array('style' => 'list-style-image:url("sqpurple.gif");'));
                                            $a2.= html_writer::start_tag('li');

                                            $b2.= html_writer::end_tag('li');
                                            $b2.= html_writer::end_tag('ul');
                                            $b.= html_writer::end_tag('h2');
                                            $b.= html_writer::end_tag('div');
                                            $b.= html_writer::end_tag('div');
                                            $b.= html_writer::end_tag('div');

                                            /* Admin Setting block (link) */
                                            $aa = $CFG->wwwroot . '/admin/roles/assign.php?contextid=1';
                                            $aa_open = "<a href='" . $aa . "' class='button'>";
                                            $ab = $CFG->wwwroot . '/userfrontpage/admin-commpreference.php';
                                            $ab_open = "<a href='" . $ab . "' class='button'>";
                                            $ac = $CFG->wwwroot . '/userfrontpage/examresult_ECadmin.php?id=' . $USER->id;
                                            $ac_open = "<a href='" . $ac . "' class='button'>";
                                            $ad = $CFG->wwwroot . '/config/uploadconfig.php';
                                            $ad_open = "<a href='" . $ad . "' class='button'>";

                                            $aemailac = $CFG->wwwroot . '/manualemail/emailactivity.php';
                                            $aemailac_open = "<a href='" . $aemailac . "' class='button'>";
                                            $aecc = $CFG->wwwroot . '/manualemail/emailcontent_config.php';
                                            $aecc_open = "<a href='" . $aecc . "' class='button'>";
                                            $av = $CFG->wwwroot . '/course/view.php?id=57'; //feedback//evaluation
                                            $av_open = "<a href='" . $av . "' class='button'>";
                                            $air = $CFG->wwwroot . '/financialinstituition/list_ofregistration_admin.php';
                                            $air_open = "<a href='" . $air . "' class='button'>";

                                            $aemail = $CFG->wwwroot . '/manualemail/manualsend_email.php';
                                            $aemail_open = "<a href='" . $aemail . "' class='button'>";

                                            $morg = $CFG->wwwroot . '/organization/edit.php';
                                            $morg_open = "<a href='" . $morg . "' class='button'>";
                                            $anews = $CFG->wwwroot . '/news_update/list_ofnews_update.php';
                                            $anews_open = "<a href='" . $anews . "' class='button'>";
                                            $ae = $CFG->wwwroot . '/userfrontpage/prospectstatus.php?id=' . $USER->id;
                                            $ae_open = "<a href='" . $ae . "' class='button'>";
                                            $af = $CFG->wwwroot . '/userfrontpage/resetpassword.php';
                                            $af_open = "<a href='" . $af . "' class='button'>";
                                            $ag = $CFG->wwwroot . '/transaction_status.php?id=' . $USER->id;
                                            $ag_open = "<a href='" . $ag . "' class='button'>";
                                            $ah = $CFG->wwwroot . '/userfrontpage/updatecandidate_details.php';
                                            $ah_open = "<a href='" . $ah . "' class='button'>";
                                            $ap = $CFG->wwwroot . '/progress_report.php?id=' . $USER->id;
                                            $bulkuser = $CFG->wwwroot . '/admin/uploaduser.php';
                                            $uploadbulkuser = "<a href='" . $bulkuser . "' class='button'>";
                                            $cert = $CFG->wwwroot . '/config/viewcertconfig.php';
                                            $cerlink = "<a href='" . $cert . "' class='button'>";

                                            /* Report block (link) */
                                            $ai = $CFG->wwwroot . '/progress_report.php?id=' . $USER->id;
                                            $ai_open = "<a href='" . $ap . "' class='button'>";
                                            $aj = $CFG->wwwroot . '/course/report/log/index.php?id=1';
                                            $aj_open = "<a href='" . $aj . "' class='button'>";
                                            $ak = $CFG->wwwroot . '/report/transaction_report.php';
                                            $ak_open = "<a href='" . $ak . "' class='button'>";
                                            $al = $CFG->wwwroot . '/report/report_1.php';
                                            $al_open = "<a href='" . $al . "' class='button'>";
                                            $am = $CFG->wwwroot . '/viewenrolmentconfirmation_editable.php';
                                            $am_open = "<a href='" . $am . "' class='button'>";
                                            $an = $CFG->wwwroot . '/examrules/admin_examrules_form.php?id=16';
                                            $an_open = "<a href='" . $an . "' class='button'>";
                                            $ao = $CFG->wwwroot . '/cifapolicy/admin_cifapolicy_form.php?id=20';
                                            $ao_open = "<a href='" . $ao . "' class='button'>";
                                            $aq = $CFG->wwwroot . '/certificate/admin_usercertificate_form.php?id=3';
                                            $aq_open = "<a href='" . $aq . "' class='button'>";
                                            $ar = $CFG->wwwroot . '/financialstatement/admin_financial_form.php?id=1';
                                            $ar_open = "<a href='" . $ar . "' class='button'>";

                                            $areport = $CFG->wwwroot . '/examcenter/myreport.php';
                                            $report_open = "<a href='" . $areport . "' class='button'>";
                                            $a_close = "</a>";

                                            if ($PAGE->pagelayout == 'frontpage') {
                                                echo $a . "SITE ADMINISTRATION" . $b; /* Admin Setting block */
                                                echo $a2 . $aa_open . get_string('assignusersroles') . $a_close . $b2;
                                                echo $a2 . $af_open . get_string('resetpassword') . $a_close . $b2;
                                                echo $a2 . $ah_open . get_string('updatecandidateinfo') . $a_close . $b2;
                                                echo $a2 . $cerlink . get_string('certconfig', 'admin') . $a_close . $b2;
                                                echo $a2 . $ab_open . get_string('communicationpreferences') . $a_close . $b2;
                                                echo $a2 . $ac_open . get_string('examresult') . $a_close . $b2;

                                                echo $a2 . $am_open . get_string('editenrolmentconfirmation') . $a_close . $b2;
                                                echo $a2 . $an_open . get_string('editexamrules') . $a_close . $b2;  // online FAQ	
                                                echo $a2 . $ao_open . get_string('editcifaonlinepolicy') . $a_close . $b2;
                                                echo $a2 . $aq_open . get_string('editusercertificate') . $a_close . $b2;
                                                echo $a2 . $ar_open . get_string('editfinancialstatement') . $a_close . $b2;

                                                echo $a2 . $aemailac_open . get_string('emailactivity') . $a_close . $b2;
                                                // echo $a2.$aecc_open.get_string('emailcontentconfig').$a_close.$b2;
                                                echo $a2 . $av_open . 'Feedback' . $a_close . $b2;
                                                echo $a2 . $air_open . get_string('instregistration') . $a_close . $b2;
                                                // echo $a2.$aemail_open.get_string('manualemailconfig').$a_close.$b2;

                                                echo $a2 . $morg_open . get_string('organizationdb') . $a_close . $b2;
                                                echo $a2 . $anews_open . get_string('news_update') . $a_close . $b2;
                                                echo $a2 . $ad_open . 'Permission to Upload' . $a_close . $b2;
                                                echo $a2 . $ae_open . get_string('prospect') . $a_close . $b2;
                                                echo $a2 . $ag_open . get_string('transactionstatus') . $a_close . $b2;
                                                echo $a2 . $uploadbulkuser . get_string('uploadbulkuser', 'admin') . $a_close . $b2;

                                                echo "<br/>";

                                                echo $a . "REPORT" . $b; /* Report block */
                                                echo $a2 . $ai_open . get_string('candidateprogress') . $a_close . $b2;
                                                echo $a2 . $aj_open . get_string('activitylog') . $a_close . $b2;
                                                echo $a2 . $ak_open . get_string('transactionreport') . $a_close . $b2;
                                                echo $a2 . $al_open . get_string('report') . $a_close . $b2;
                                                echo $a2 . $report_open . get_string('reportmanagement') . $a_close . $b2;
                                                echo "<br/>";
                                            }
                                            ?>				
                                        </div>				
                                    </div>
<?php } ?>
                            </div>
                        </div>
                    </div></div>
                <!-- END OF CONTENT --> 
            </div>      

            <br style="clear: both;"> 
            <?php
            echo html_writer::start_tag('div', array('id' => 'page-footer'));
            echo html_writer::end_tag('div');
            if ($hasfooter) {
                echo html_writer::start_tag('div', array('id' => 'footerwrapper'));
                include('footer_custom.php');
            }
            echo html_writer::end_tag('div');
            echo html_writer::end_tag('div');
            echo $OUTPUT->standard_end_of_body_html()
            ?>
            </body>
            </html>