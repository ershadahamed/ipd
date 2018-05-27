<?php

$divclose = html_writer::end_tag('div');
$clearfix = html_writer::start_tag('div', array('class' => 'clearfix')) . $divclose;

echo html_writer::start_tag('div', array('id' => 'main-header'));
echo html_writer::start_tag('div', array('class' => 'container_2'));
echo html_writer::start_tag('div', array('id' => 'main-topbar'));
if (!isloggedin()) {
    echo html_writer::start_tag('div', array('id' => 'main-menu', 'style' => 'width:100%'));
} else {
    echo html_writer::start_tag('div', array('id' => 'main-menu'));
}

// Top menu link
$toplink = array();
$toplink[0] = $CFG->wwwroot . '/theme/aardvark/pix/glyphicons.png';                                 // glyphicons Icon
$toplink[1] = $CFG->wwwroot . '/index.php';                                                         // Home
$toplink[2] = $CFG->wwwroot . '/examcenter/myreport.php?id=' . $USER->id;                           // My Admin
$toplink[3] = $CFG->wwwroot . '/mod/chat/gui_ajax/index.php?id=4';                                  // IPD Chat
$toplink[4] = $CFG->wwwroot . '/contactus/upload_index.php';                                        // Contact Us
$toplink[5] = $CFG->wwwroot . '/candidatemanagement/cifacandidatemanagement.php?id=' . $USER->id;   // My Candidate
$toplink[6] = $CFG->wwwroot . '/offlineexam/multi_token_download.php?id=' . $USER->id;              // My Exam Center
$toplink[7] = $CFG->wwwroot . '/coursesindex.php?id=' . $USER->id;                                  // My Training
$toplink[8] = $CFG->wwwroot . '/purchasemodule.php?id=' . $USER->id;                                // Buy IPD
$toplink[9] = $CFG->wwwroot . '/coursesindex.php';                                                  // Enroll Now // My Courses
$toplink[10] = $CFG->wwwroot . '/examsindex.php?id=' . $USER->id;                                   // Admin // Test Module
$toplink[11] = new moodle_url('/course/view.php', array('id' => '57'));                             // Admin // Feedback  
// Top menu link name
$topmenuname = array();
$topmenuname[0] = get_string('home');            // Home
$topmenuname[1] = get_string('myadmin');         // My Admin
$topmenuname[2] = get_string('cifachat');        // IPD Chat
$topmenuname[3] = get_string('contactus');       // Contact Us
$topmenuname[4] = get_string('mycandidate');     // My Candidate
$topmenuname[5] = get_string('myexamcenter');    // My Exam Center
$topmenuname[6] = get_string('mycourses');       // My Courses
$topmenuname[7] = get_string('buyacifa');        // Buy IPD
$topmenuname[8] = get_string('adminmodules');    // Admin Modules
$topmenuname[9] = 'Tests';
$topmenuname[10] = get_string('feedback');        // Feedback
$topmenuname[11] = get_string('enrollnow');       // Enroll Now

$glyphicons = '<img class="glyphicon" style="width:23px;" src="' . $toplink[0] . '" />';
$ulopen = html_writer::start_tag('ul', array('class' => 'menu-list'));
$ulclose = html_writer::end_tag('ul');
$lihomeopen = html_writer::start_tag('li', array('class' => 'menu-item home'));
$liopen = html_writer::start_tag('li', array('class' => 'menu-item'));
$liclose = html_writer::end_tag('li');

$homemenu = '<li class="menu-item home"><a href=' . $toplink[1] . ' class="menu-link"><i>' . $glyphicons . '</i></a>' . $liclose;
$myadminmenu = $liopen . '<a href=' . $toplink[2] . ' class="menu-link">' . $topmenuname[1] . '</a>' . $liclose;
$chattopmenu = $liopen . '<a target="_blank" href=' . $toplink[3] . ' class="menu-link">' . $topmenuname[2] . '</a>' . $liclose;
$contactustopmenu = $liopen . '<a href=' . $toplink[4] . ' class="menu-contact">' . $topmenuname[3] . '</a>' . $liclose;

$mytrainingmenu = $liopen . '<a href=' . $toplink[7] . ' class="menu-link">' . $topmenuname[6] . '</a>' . $liclose;
$buymenu = $liopen . '<a href=' . $toplink[8] . ' class="menu-link">' . $topmenuname[7] . '</a>' . $liclose;
$mycandidatemenu = $liopen . '<a href=' . $toplink[5] . ' class="menu-link">' . $topmenuname[4] . '</a>' . $liclose;
$examcentermenu = $liopen . '<a href=' . $toplink[6] . ' class="menu-link">' . $topmenuname[5] . '</a>' . $liclose;

// Administrator Menu
$modulesmenu = $liopen . '<a href=' . $toplink[9] . ' class="menu-link">' . $topmenuname[8] . '</a>' . $liclose;
$testsmenu = $liopen . '<a href=' . $toplink[10] . ' class="menu-link">' . $topmenuname[9] . '</a>' . $liclose;
$feedbackmenu = $liopen . '<a href=' . $toplink[11] . ' class="menu-link">' . $topmenuname[10] . '</a>' . $liclose;
$enrollnowmenu = $liopen . '<a href=' . $toplink[9] . ' class="menu-link">' . $topmenuname[11] . '</a>' . $liclose;
$enrollnowmenu_notlogged = $liopen . '<a href=' . $toplink[9] . ' class="menu-contact">' . $topmenuname[11] . '</a>' . $liclose;

// GUEST MENU
$guestcoursemenu = $liopen . '<a href="#" class="menu-link">' . $topmenuname[6] . '</a>' . $liclose;
$guestbuymenu = $liopen . '<a href="#" class="menu-link">' . $topmenuname[7] . '</a>' . $liclose;
$guestchattopmenu = $liopen . '<a href="#" class="menu-link">' . $topmenuname[2] . '</a>' . $liclose;
$guestcontactustopmenu = $liopen . '<a href="#" class="menu-contact">' . $topmenuname[3] . '</a>' . $liclose;

include 'manualdbconfig.php';
$sql = mysql_query("SELECT * FROM mdl_cifarole_assignments WHERE contextid='1' AND userid='" . $USER->id . "'");
$rs = mysql_fetch_array($sql);

//is loggin
echo $ulopen;
echo $homemenu;
if (isloggedin()) {
    $getUserId=get_user_details($USER->id)->id;
    if ($USER->id != '2') { //if not administartor
        $groupuserid = $rs['roleid'];
        if ($groupuserid == '13') { // HR admin
            echo $myadminmenu;
        } else if ($groupuserid == '12') { // Business Partner  
            echo $mycandidatemenu;
        } else if ($groupuserid == '10') { // exam center  
            echo $examcentermenu;
        } else { //Active Candidate
            if ($USER->id != '1') {
                // NOT A GUEST 
                echo $mytrainingmenu;
                echo $buymenu;
            } else {
                // GUEST here!!!
                echo $guestcoursemenu;
                echo $guestbuymenu;
                echo $guestchattopmenu;
                echo $guestcontactustopmenu;
            }
        }
        echo $chattopmenu;
        echo $contactustopmenu;
    } else { //administartor 
        echo $modulesmenu;
        echo $testsmenu;
        echo $chattopmenu;
        echo $feedbackmenu;
    }
} else {  // Jika tak loggin // not loggin user here //
    echo $enrollnowmenu_notlogged;
}
echo $ulclose;
echo $divclose; // #main-menu
echo $clearfix; // .clearfix 
echo $divclose; // #main-topbar 
//
$change_pic_link = $CFG->wwwroot . '/user/edit_picture.php?id=' . $USER->id . '&course=1';

$linkimg = array();
$linkimg[] = $CFG->wwwroot . '/image/f1.png';
$linkimg[] = $CFG->wwwroot . '/user/pix.php?file=/' . $USER->id . '/f1.jpg';
$linkimg[] = $CFG->wwwroot . '/user/profile.php?id=' . $USER->id;               // profile link
$linkimg[] = $CFG->wwwroot . "/login/logout.php?sesskey=" . sesskey();          // logout

echo html_writer::start_tag('div', array('class' => 'header-content'));
echo html_writer::start_tag('div', array('id' => 'main-logo-sm'));
echo '<img width="118px" src="' . $PAGE->theme->settings->logo . '" />';
echo $divclose;         // #main-logo-sm 
echo html_writer::start_tag('div', array('class' => 'row'));
echo html_writer::start_tag('div', array('class' => 'col-md-5')) . $divclose;
echo html_writer::start_tag('div', array('class' => 'col-md-7'));
echo html_writer::start_tag('div', array('id' => 'main-profile-bar'));
if (isloggedin()) {
    echo html_writer::start_tag('div', array('class' => 'thumbnail'));
    if ($USER->picture == '0') {
        echo '<a href="' . $change_pic_link . '" title="change picture"><img src="' . $linkimg[0] . '" width="90px" alt="' . $USER->firstname . ' ' . $USER->lastname . '" /></a>';
    } else {
        echo '<a href="' . $change_pic_link . '" title="change picture"><img src="' . $linkimg[1] . '" width="90px" alt="' . $USER->firstname . ' ' . $USER->lastname . '" /></a>';
    }
    echo $divclose;     //  .thumbnail
}

echo html_writer::start_tag('div', array('class' => 'content', 'style' => 'float:right'));
if (isloggedin()) {
    echo html_writer::start_tag('div', array('class' => 'item username'));
    echo ucwords(strtolower($USER->firstname)); // Display user name
    echo $divclose;
    echo html_writer::start_tag('div', array('class' => 'item user-id margin-sm-bottom')) . $divclose;
    echo html_writer::start_tag('div', array('class' => 'item menu'));
    //echo html_link::make(new moodle_url($CFG->wwwroot . '/user/profile.php', array('id' => $USER->id, 'class'=>'theme-button')), get_string('myaccount'));
    echo '<a class="theme-button" style="color: #FFFFFF;" href="' . $linkimg[2] . '" title="' . get_string('myaccount') . '">' . get_string('myaccount') . '</a>';
    echo '<a class="theme-button" style="color: #FFFFFF;" href="' . $linkimg[3] . '" title="' . get_string('logout') . '">' . get_string('logout') . '</a>';
    echo $divclose;     //  .item menu
}
echo $divclose;     //  .content<div class="item menu">
echo $clearfix;     //  .clearfix
echo $divclose;     //  #main-profile-bar
echo $clearfix;     //  .clearfix
echo $divclose;     //  .col-md-7
echo $divclose;     //  .row
echo $divclose;     //  .header-content
echo $divclose;     //  .container
echo $divclose;     //  #main-header