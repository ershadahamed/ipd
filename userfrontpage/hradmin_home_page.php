<style>
    .col-md-1,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-md-10,
    .col-md-11,
    .col-md-12{
        /* padding-left: 15px; */
        padding-right: 15px; 
    }

    .widget-app .link-list {
        margin: 0px;
    }

</style>
<script type="text/javascript">
    function popupwindow(url, title, w, h) {//Center PopUp Window added by Arizan
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }
</script>
<?php
//new curiculum/ipd course
$today = date('d-m-Y H:i:s', strtotime('now'));

//IPD candidate 
$IPDstatement = " mdl_cifauser a, mdl_cifauser_program b WHERE a.id=b.userid AND a.deleted!='1' AND b.programid='1' AND b.userid='" . $USER->id . "'";
$selIPD = mysql_query("SELECT * FROM {$IPDstatement}");
$cIPD = mysql_num_rows($selIPD);

//header menu//
$link_myaccount = '<a class="link" href="' . $CFG->wwwroot . '/user/profile.php?id=' . $USER->id . '">';
$link_mytraining = '<a class="link" href="' . $CFG->wwwroot . '/coursesindex.php?id=' . $USER->id . '">';
$link_mycommunity = '<a class="link" href="' . $CFG->wwwroot . '/userfrontpage/mycommunitypage.php?id=' . $USER->id . '">';
$link_mockexam = '<a class="link" href="' . $CFG->wwwroot . '/course/mock_exam.php?id=' . $USER->id . '">';
$ahref_close = '</a>';

//link menu
$flinkmenu = $CFG->wwwroot . '/financialstatement/financial.php';
$utube = $PAGE->theme->settings->youtube;
$socialnetwork = $CFG->wwwroot . '/mc_socialnetwork.php';

$rolesql = mysql_query("SELECT * FROM {$CFG->prefix}role_assignments WHERE contextid='1' AND userid='" . $USER->id . "'");
$rs = mysql_fetch_array($rolesql);
?>
<p style="font-size:20px;font-weight:bolder;margin-bottom:1.3em;"><?= get_string('welcomenote'); ?></p>
<div id="main-app-body">
    <div class="container">

        <div class="row">
            <div class="col-md-13"> 
                <?php
                $selectstatement2 = mysql_query("SELECT * FROM mdl_cifacandidates WHERE traineeid='" . $USER->traineeid . "'");
                $ssql2 = mysql_num_rows($selectstatement2);
                ?>				
                <div class="row margin-lg-bottom">
                    <div class="col-md-4">
                        <div class="widget-app-header">
                            <div class="title"><?= $link_myaccount . get_string('myaccount') . $ahref_close; ?></div>
                        </div><!-- .widget-app-header -->                        
                            <div class="widget-app-body">
                                <div class="link-list">
                                    <a class="blockbar" href="<?php echo $CFG->wwwroot . '/user/profile.php?id=' . $USER->id; ?>">
                                            <?= get_string('profile'); ?></a>
                                    <a class="blockbar" href="<?php echo $CFG->wwwroot . '/login/change_password.php?id=1'; ?>">
                                            <?= get_string('changepassword'); ?></a>
                                    <a class="blockbar" href="#"><?= get_string('onlineportal'); ?></a>
                                </div><!-- .link-list -->
                            </div><!-- .widget-app-body -->
                    </div><!-- .col-md-4 -->
                    <div class="col-md-4">
                        <div class="widget-app-header">
                            <div class="title" style="color:#6D6E71;">
                                <?php
                                if ($rs['roleid'] != '12') { //hr admin
                                    echo get_string('myadmin');
                                } else {
                                    echo get_string('mycandidate');
                                }
                                ?>
                            </div>
                        </div><!-- .widget-app-header -->                       
                            <div class="widget-app-body">
                                <div class="link-list">
                                    <a class="blockbar" href="<?= $CFG->wwwroot . '/candidatemanagement/cifacandidatemanagement.php?id=' . $USER->id; ?>"><?= get_string('candidatemanagement'); ?></a>
                                    <a class="blockbar" href="<?= $CFG->wwwroot . '/candidatemanagement/cifacandidatemanagement.php?id=' . $USER->id; ?>"><?= get_string('resetpword'); ?></a>
                                    <a class="blockbar" href="<?= $CFG->wwwroot . '/candidatemanagement/cifacandidatemanagement.php?id=' . $USER->id; ?>"><?= get_string('updatedetails'); ?></a>                                                                             
                                    <?php if ($rs['roleid'] != '12') { //hr admin  ?>
                                        <a class="blockbar" href="<?= $CFG->wwwroot . '/examcenter/myreport.php'; ?>"><?= get_string('reportmanagement'); ?></a>
                                        <a class="blockbar" href="<?= $CFG->wwwroot . '/examcenter/myreport.php'; ?>"><?= get_string('creatednewreport'); ?></a>
                                        <a class="blockbar" href="<?= $CFG->wwwroot . '/examcenter/myreport.php'; ?>"><?= get_string('scheduledreport'); ?></a>
                                    <?php } ?>
                                </div><!-- .link-list -->
                            </div><!-- .widget-app-body -->
                    </div><!-- .col-md-4 -->
                    <div class="col-md-4">
                        <div class="widget-app-header">
                            <div class="title">
                                <?php if ($rs['roleid'] != '12') { //hr admin ?>
                                    <?= $link_mycommunity . get_string('mycommunity') . $ahref_close; ?>
                                <?php
                                } else {
                                    echo get_string('myreport');
                                }
                                ?>
                            </div>
                        </div><!-- .widget-app-header -->                       
                            <div class="widget-app-body">
                                <div class="link-list">
<?php if ($rs['roleid'] != '12') { //hr admin   ?>
                                            <a class="blockbar" href="<?php echo $CFG->wwwroot . '/mod/chat/gui_ajax/index.php?id=4'; ?>" target="_blank"><?= get_string('cifachat'); ?></a>
                                            <a class="blockbar" href="#"><?= get_string('cifablog'); ?></a>
                                            <a class="blockbar" href="<?= $utube; ?>" target="_blank"><?= get_string('youtube'); ?></a>                                       
                                            <a class="blockbar" title="<?= get_string('socialnetwork'); ?>" href="javascript:void(0);" onclick="popupwindow('<?= $socialnetwork; ?>', 'googlePopup', 1000, 500);"><?= get_string('socialnetwork'); ?></a>
                                            <a class="blockbar" href="<?php echo $CFG->wwwroot . '/mod/feedback/complete.php?id=207&courseid=&gopage=0'; ?>"><?= get_string('feedbackreview'); ?></a>				
<?php } else { ?>
                                            <a class="blockbar" href="<?= $CFG->wwwroot . '/examcenter/myreport.php'; ?>"><?= get_string('reportmanagement'); ?></a>
                                            <a class="blockbar" href="<?= $CFG->wwwroot . '/examcenter/myreport.php?id=' . $USER->id; ?>"><?= get_string('creatednewreport'); ?></a>
                                            <a class="blockbar" href="<?= $CFG->wwwroot . '/examcenter/myreport.php?id=' . $USER->id; ?>"><?= get_string('scheduledreport'); ?></a>
<?php } ?>
                                </div><!-- .link-list -->
                            </div><!-- .widget-app-body -->
                    </div><!-- .col-md-4 -->
                </div><!-- .row -->
            </div><!-- .col-md-9 -->
            <div class="col-md-3">
                <div class="widget-app-header">
                    <div class="title" style="color:#6D6E71;"><?= get_string('news_update'); ?></div>
                </div><!-- .widget-app-header -->                
                <div class="widget-app">
                    <div class="widget-app-body"  style="padding:0px 12px 12px;">
                        <div class="post-list margin-md-top" style="margin-top:0px;">
                            <div class="post"> 
                                <!--div class="header"></div-->
                                <div class="excerpt">
                                    <?php
                                    $newlink = $CFG->wwwroot . '/image/new_animated.gif';
                                    $snews = mysql_query("SELECT * FROM {$CFG->prefix}news_update WHERE status='0'");
                                    while ($news = mysql_fetch_array($snews)) {
                                        echo $news['title'] . '&nbsp;<img src="' . $newlink . '" width="23"><br/>';
                                    }

                                    $selectnew = mysql_query("SELECT * FROM mdl_cifacourse WHERE visible='1' AND (category!='0' AND category!='3' AND category!='6') ORDER BY id DESC");
                                    $n = '0';
                                    $ab = '0';
                                    while ($serow = mysql_fetch_array($selectnew)) {
                                        $n++;
                                        $ab++;
                                        $createdate = date('d-m-Y H:i:s', $serow['timecreated']);
                                        $expireddate = date('d-m-Y H:i:s', strtotime($createdate . " + 1 month"));

                                        $current = strtotime('now');
                                        $start = strtotime($createdate);
                                        $ex = strtotime($expireddate);

                                        if ($start <= $current && $current <= $ex) {
                                            $sc = mysql_query("SELECT * FROM mdl_cifacourse_categories WHERE id!='3' AND id='" . $serow['category'] . "'");
                                            $rws = mysql_fetch_array($sc);
                                            $newlink = $CFG->wwwroot . '/image/new_animated.gif';
                                            $link_to_course = $CFG->wwwroot . '/course/view.php?id=' . $serow['id'];
                                            $link_open = "<a href='" . $link_to_course . "' title='Click to open " . $serow['fullname'] . "'>";
                                            $link_close = "</a>";

                                            $sql_cek = mysql_query("
													Select
													  *
													From
													  mdl_cifaenrol a Inner Join
													  mdl_cifauser_enrolments b On a.id = b.enrolid
													Where
													  b.userid = '" . $USER->id . "' And
													  a.courseid = '" . $serow['id'] . "'												
												");
                                            $c_even = mysql_num_rows($sql_cek);
                                            // echo $link_open.$serow['fullname'].'&nbsp;<img src="'.$newlink.'" width="23">'.$link_close.'<br/>';
                                        }

                                        //quiz//exam//mockexam
                                        $query_mock = mysql_query("SELECT * FROM mdl_cifaquiz WHERE course='" . $serow['id'] . "'");
                                        $s_mock = mysql_fetch_array($query_mock);
                                        $mock_createdate = date('d-m-Y H:i:s', $s_mock['timemodified']);
                                        $mock_expireddate = date('d-m-Y H:i:s', strtotime($mock_createdate . " + 1 month"));

                                        $m_current = strtotime('now');
                                        $m_start = strtotime($mock_createdate);
                                        $m_ex = strtotime($mock_expireddate);

                                        if ($m_start <= $m_current && $m_current <= $m_ex) {
                                            $m_sc = mysql_query("SELECT * FROM mdl_cifacourse_modules WHERE course='" . $s_mock['course'] . "' AND instance='" . $s_mock['id'] . "'");
                                            $m_rws = mysql_fetch_array($m_sc);
                                            $newlink = $CFG->wwwroot . '/image/new_animated.gif';
                                            $link_to_mock = $CFG->wwwroot . '/mod/quiz/view.php?id=' . $m_rws['id'];
                                            $m_link_open = "<a href='" . $link_to_mock . "' title='Click to start " . $s_mock['name'] . "'>";
                                            $link_close = "</a>";

                                            $sql_cek = mysql_query("
													Select
													  *
													From
													  mdl_cifaenrol a Inner Join
													  mdl_cifauser_enrolments b On a.id = b.enrolid
													Where
													  b.userid = '" . $USER->id . "' And
													  a.courseid = '" . $serow['id'] . "'
													Order By
													  b.id
												");
                                            $c_even = mysql_num_rows($sql_cek);
                                            // echo $m_link_open.$s_mock['name'].'&nbsp;<img src="'.$newlink.'" width="23">'.$link_close.'<br/>';
                                        }
                                    }
                                    ?>
                                </div><!-- .excerpt -->
                                <!--div class="date">July 22, 2013</div-->
                            </div><!-- .post -->
                        </div><!-- .post-list -->
                    </div><!-- .widget-app-body -->
                </div><!-- .widget-app -->
            </div><!-- .col-md-3 -->
        </div><!-- .row -->

    </div><!-- .container -->
</div><!-- #main-app-body -->