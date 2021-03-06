<?php

// Display the whole course as "topics" made of of modules
// Included from "view.php"
/**
 * Evaluation topics format for course display - NO layout tables, for accessibility, etc.
 *
 * A duplicate course format to enable the Moodle development team to evaluate
 * CSS for the multi-column layout in place of layout tables.
 * Less risk for the Moodle 1.6 beta release.
 *   1. Straight copy of topics/format.php
 *   2. Replace <table> and <td> with DIVs; inline styles.
 *   3. Reorder columns so that in linear view content is first then blocks;
 * styles to maintain original graphical (side by side) view.
 *
 * Target: 3-column graphical view using relative widths for pixel screen sizes
 * 800x600, 1024x768... on IE6, Firefox. Below 800 columns will shift downwards.
 *
 * http://www.maxdesign.com.au/presentation/em/ Ideal length for content.
 * http://www.svendtofte.com/code/max_width_in_ie/ Max width in IE.
 *
 * @copyright &copy; 2006 The Open University
 * @author N.D.Freear@open.ac.uk, and others.
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/filelib.php');
require_once($CFG->libdir.'/completionlib.php');

$topic = optional_param('topic', -1, PARAM_INT);

if ($topic != -1) {
    $displaysection = course_set_display($course->id, $topic);
} else {
    $displaysection = course_get_display($course->id);
}

$context = get_context_instance(CONTEXT_COURSE, $course->id);

if (($marker >=0) && has_capability('moodle/course:setcurrentsection', $context) && confirm_sesskey()) {
    $course->marker = $marker;
    $DB->set_field("course", "marker", $marker, array("id"=>$course->id));
}

$streditsummary  = get_string('editsummary');
$stradd          = get_string('add');
$stractivities   = get_string('activities');
$strshowalltopics = get_string('showalltopics');
$strtopic         = get_string('topic');
$strgroups       = get_string('groups');
$strgroupmy      = get_string('groupmy');
$editing         = $PAGE->user_is_editing();

if ($editing) {
    $strtopichide = get_string('hidetopicfromothers');
    $strtopicshow = get_string('showtopicfromothers');
    $strmarkthistopic = get_string('markthistopic');
    $strmarkedthistopic = get_string('markedthistopic');
    $strmoveup   = get_string('moveup');
    $strmovedown = get_string('movedown');
}

    //added by arizanabdullah on 16052012
   include('../manualdbconfig.php');
   
    $sqlD="SELECT * FROM {$CFG->prefix}role_assignments WHERE userid='".$USER->id."' AND contextid='1'";
    $sqlQ=mysql_query($sqlD);
    $rs=mysql_fetch_array($sqlQ); 

// Print the Your progress icon if the track completion is enabled
$completioninfo = new completion_info($course);
echo $completioninfo->display_help_icon();
if($rs['roleid'] == '3'){
	echo $OUTPUT->heading(get_string('additionalresources'), 2, 'headingblock header outline');
}else{
	if($USER->id == '2'){
		echo $OUTPUT->heading(get_string('topicoutline'), 2, 'headingblock header outline');
	}
}

if($rs['roleid']=='10' || ($USER->id == '2')){

// Note, an ordered list would confuse - "1" could be the clipboard or summary.
echo "<ul class='topics'>\n";

/// If currently moving a file then show the current clipboard
if (ismoving($course->id)) {
    $stractivityclipboard = strip_tags(get_string('activityclipboard', '', $USER->activitycopyname));
    $strcancel= get_string('cancel');
    echo '<li class="clipboard">';
    echo $stractivityclipboard.'&nbsp;&nbsp;(<a href="mod.php?cancelcopy=true&amp;sesskey='.sesskey().'">'.$strcancel.'</a>)';
    echo "</li>\n";
}

/// Print Section 0 with general activities

$section = 0;
$thissection = $sections[$section];
unset($sections[0]);

if ($thissection->summary or $thissection->sequence or $PAGE->user_is_editing()) {

    // Note, no need for a 'left side' cell or DIV.
    // Note, 'right side' is BEFORE content.
    echo '<li id="section-0" class="section main clearfix" >';
    echo '<div class="left side">&nbsp;</div>';
    echo '<div class="right side" >&nbsp;</div>';
    echo '<div class="content">';
	
	echo "<div style='font-size:1.5em; font-weight:bolder;'>".$COURSE->fullname."</div>";
	//ADDED BY arizanabdullah ON 21/12/2011
	//echo '<p><span style="font-size: large;"><strong>';
	//echo ucwords(strtolower($course->fullname));
	//echo '</strong></span></p>';
	//end ADDED BY ARIZANABDULLAH ON 21/12/2011	
	
    if (!is_null($thissection->name)) {
        //echo $OUTPUT->heading($thissection->name, 3, 'sectionname'); //remove by arizan abdullah
    }
	
    echo '<div class="summary">';	
    $coursecontext = get_context_instance(CONTEXT_COURSE, $course->id);
    $summarytext = file_rewrite_pluginfile_urls($thissection->summary, 'pluginfile.php', $coursecontext->id, 'course', 'section', $thissection->id);
    $summaryformatoptions = new stdClass();
    $summaryformatoptions->noclean = true;
    $summaryformatoptions->overflowdiv = true;
    echo format_text($summarytext, $thissection->summaryformat, $summaryformatoptions);

    if ($PAGE->user_is_editing() && has_capability('moodle/course:update', $coursecontext)) {
        echo '<a title="'.$streditsummary.'" '.
             ' href="editsection.php?id='.$thissection->id.'"><img src="'.$OUTPUT->pix_url('t/edit') . '" '.
             ' class="icon edit" alt="'.$streditsummary.'" /></a>';
    }
    echo '</div>';

    print_section($course, $thissection, $mods, $modnamesused);
    
    //added by arizanabdullah on 16052012
   include('../manualdbconfig.php');
   
    $sqlD="SELECT * FROM {$CFG->prefix}role_assignments WHERE userid='".$USER->id."' AND contextid='1'";
    $sqlQ=mysql_query($sqlD);
    $rs=mysql_fetch_array($sqlQ);    

    if($COURSE->id == '12'){ //exam and question bank section on course
	
		$examsoftware=get_string('backup');
		$exam_newsoftware='Generate new exam software';
		$generate_software = new moodle_url('/backup/backup.php', array('id'=>$COURSE->id));	
		
        if($rs['roleid']=='10' || ($USER->id == '2')){
            
			$sqlOperation="SELECT *, date_format(from_unixtime(timemodified), '%Y-%m-%d') as timemodified FROM {$CFG->prefix}files WHERE component='backup' ORDER BY id DESC";

            $sqlRw=mysql_query($sqlOperation);
            $rs1=mysql_fetch_array($sqlRw);
            
            $threedayOn = date('Y-m-d',strtotime($rs1['timemodified'] . " + 1 day"));
			if(($rs1['timecreated']<=date('Y-m-d'))&& (date('Y-m-d')<=$threedayOn)){
            
            echo 'Date created token: '.$rs1['timemodified'].' <br/>Date today: '.date('Y-m-d');   
            echo '<br/> Date expired: '.$threedayOn; 
                
            echo '<br/><br/>';      
            
            echo $OUTPUT->container_start();
            $treeview_options = array();
            $treeview_options['filecontext'] = $context;
            $treeview_options['currentcontext'] = $context;
            $treeview_options['component']   = 'backup';
            $treeview_options['context']     = $context;
            $treeview_options['filearea']    = 'course';
            $renderer = $PAGE->get_renderer('core', 'backup');
            echo $renderer->backup_files_viewer($treeview_options);
            echo $OUTPUT->container_end(); 
            echo '<br/>';
			
			if($USER->id == '2'){
				//echo '<a href="'.$generate_software.'" title="click here to '.$exam_newsoftware.'">'.$exam_newsoftware.'</a><br/><br/>';
				echo html_writer::start_tag('div', array('style'=>'float:left;'));
				echo $OUTPUT->single_button($generate_software, $exam_newsoftware, 'post');
				echo html_writer::end_tag('div');
				echo '<br/><br/>';
			}
			
			}else{ 
				echo '- No files to download. <br/><br/>';
				if($USER->id == '2'){
					//echo '<a href="'.$generate_software.'" title="click here to '.$examsoftware.'">'.$examsoftware.'</a><br/><br/>';
					echo html_writer::start_tag('div', array('style'=>'float:left;'));
					echo $OUTPUT->single_button($generate_software, $examsoftware, 'post');
					echo html_writer::end_tag('div');
					echo '<br/><br/>';
				}				
			}
        //end by arizanabdullah on 16052012
        }
    }    

    if ($PAGE->user_is_editing()) {
        print_section_add_menus($course, $section, $modnames);
    }

    echo '</div>';
    echo "</li>\n";
}


/// Now all the normal modules by topic
/// Everything below uses "section" terminology - each "section" is a topic.

if($rs['roleid']!='10'){ //add by arizan

$timenow = time();
$section = 1;
$sectionmenu = array();

while ($section <= $course->numsections) {

    if (!empty($sections[$section])) {
        $thissection = $sections[$section];

    } else {
        $thissection = new stdClass;
        $thissection->course  = $course->id;   // Create a new section structure
        $thissection->section = $section;
        $thissection->name    = null;
        $thissection->summary  = '';
        $thissection->summaryformat = FORMAT_HTML;
        $thissection->visible  = 1;
        $thissection->id = $DB->insert_record('course_sections', $thissection);
    }

    $showsection = (has_capability('moodle/course:viewhiddensections', $context) or $thissection->visible or !$course->hiddensections);

    if (!empty($displaysection) and $displaysection != $section) {  // Check this topic is visible
        if ($showsection) {
            $sectionmenu[$section] = get_section_name($course, $thissection);
        }
        $section++;
        continue;
    }

    if ($showsection) {

        $currenttopic = ($course->marker == $section);

        $currenttext = '';
        if (!$thissection->visible) {
            $sectionstyle = ' hidden';
        } else if ($currenttopic) {
            $sectionstyle = ' current';
            $currenttext = get_accesshide(get_string('currenttopic','access'));
        } else {
            $sectionstyle = '';
        }

        echo '<li id="section-'.$section.'" class="section main clearfix'.$sectionstyle.'" >'; //'<div class="left side">&nbsp;</div>';

            echo '<div class="left side">'.$currenttext.$section.'</div>';
        // Note, 'right side' is BEFORE content.
        echo '<div class="right side">';

        if ($displaysection == $section) {    // Show the zoom boxes
            echo '<a href="view.php?id='.$course->id.'&amp;topic=0#section-'.$section.'" title="'.$strshowalltopics.'">'.
                 '<img src="'.$OUTPUT->pix_url('i/all') . '" class="icon" alt="'.$strshowalltopics.'" /></a><br />';
        } else {
            $strshowonlytopic = get_string("showonlytopic", "", $section);
            echo '<a href="view.php?id='.$course->id.'&amp;topic='.$section.'" title="'.$strshowonlytopic.'">'.
                 '<img src="'.$OUTPUT->pix_url('i/one') . '" class="icon" alt="'.$strshowonlytopic.'" /></a><br />';
        }

        if ($PAGE->user_is_editing() && has_capability('moodle/course:update', get_context_instance(CONTEXT_COURSE, $course->id))) {

            if ($course->marker == $section) {  // Show the "light globe" on/off
                echo '<a href="view.php?id='.$course->id.'&amp;marker=0&amp;sesskey='.sesskey().'#section-'.$section.'" title="'.$strmarkedthistopic.'">'.'<img src="'.$OUTPUT->pix_url('i/marked') . '" alt="'.$strmarkedthistopic.'" /></a><br />';
            } else {
                echo '<a href="view.php?id='.$course->id.'&amp;marker='.$section.'&amp;sesskey='.sesskey().'#section-'.$section.'" title="'.$strmarkthistopic.'">'.'<img src="'.$OUTPUT->pix_url('i/marker') . '" alt="'.$strmarkthistopic.'" /></a><br />';
            }

            if ($thissection->visible) {        // Show the hide/show eye
                echo '<a href="view.php?id='.$course->id.'&amp;hide='.$section.'&amp;sesskey='.sesskey().'#section-'.$section.'" title="'.$strtopichide.'">'.
                     '<img src="'.$OUTPUT->pix_url('i/hide') . '" class="icon hide" alt="'.$strtopichide.'" /></a><br />';
            } else {
                echo '<a href="view.php?id='.$course->id.'&amp;show='.$section.'&amp;sesskey='.sesskey().'#section-'.$section.'" title="'.$strtopicshow.'">'.
                     '<img src="'.$OUTPUT->pix_url('i/show') . '" class="icon hide" alt="'.$strtopicshow.'" /></a><br />';
            }
            if ($section > 1) {                       // Add a arrow to move section up
                echo '<a href="view.php?id='.$course->id.'&amp;random='.rand(1,10000).'&amp;section='.$section.'&amp;move=-1&amp;sesskey='.sesskey().'#section-'.($section-1).'" title="'.$strmoveup.'">'.
                     '<img src="'.$OUTPUT->pix_url('t/up') . '" class="icon up" alt="'.$strmoveup.'" /></a><br />';
            }

            if ($section < $course->numsections) {    // Add a arrow to move section down
                echo '<a href="view.php?id='.$course->id.'&amp;random='.rand(1,10000).'&amp;section='.$section.'&amp;move=1&amp;sesskey='.sesskey().'#section-'.($section+1).'" title="'.$strmovedown.'">'.
                     '<img src="'.$OUTPUT->pix_url('t/down') . '" class="icon down" alt="'.$strmovedown.'" /></a><br />';
            }
        }
        echo '</div>';

        echo '<div class="content">';
        if (!has_capability('moodle/course:viewhiddensections', $context) and !$thissection->visible) {   // Hidden for students
            echo get_string('notavailable');
        } else {
            if (!is_null($thissection->name)) {
                echo $OUTPUT->heading($thissection->name, 3, 'sectionname');
            }
            echo '<div class="summary">';
            if ($thissection->summary) {
                $coursecontext = get_context_instance(CONTEXT_COURSE, $course->id);
                $summarytext = file_rewrite_pluginfile_urls($thissection->summary, 'pluginfile.php', $coursecontext->id, 'course', 'section', $thissection->id);
                $summaryformatoptions = new stdClass();
                $summaryformatoptions->noclean = true;
                $summaryformatoptions->overflowdiv = true;
                echo format_text($summarytext, $thissection->summaryformat, $summaryformatoptions);
            } else {
               echo '&nbsp;';
            }

            if ($PAGE->user_is_editing() && has_capability('moodle/course:update', get_context_instance(CONTEXT_COURSE, $course->id))) {
                echo ' <a title="'.$streditsummary.'" href="editsection.php?id='.$thissection->id.'">'.
                     '<img src="'.$OUTPUT->pix_url('t/edit') . '" class="icon edit" alt="'.$streditsummary.'" /></a><br /><br />';
            }
            echo '</div>';

            print_section($course, $thissection, $mods, $modnamesused);
            echo '<br />';
            if ($PAGE->user_is_editing()) {
                print_section_add_menus($course, $section, $modnames);
            }
        }

        echo '</div>';
        echo "</li>\n";
    }

    unset($sections[$section]);
    $section++;
}
} echo '<div style="min-height:58px;"></div>'; //add by aa
if (!$displaysection and $PAGE->user_is_editing() and has_capability('moodle/course:update', get_context_instance(CONTEXT_COURSE, $course->id))) {
    // print stealth sections if present
    $modinfo = get_fast_modinfo($course);
    foreach ($sections as $section=>$thissection) {
        if (empty($modinfo->sections[$section])) {
            continue;
        }

        echo '<li id="section-'.$section.'" class="section main clearfix orphaned hidden">'; //'<div class="left side">&nbsp;</div>';

        echo '<div class="left side">';
        echo '</div>';
        // Note, 'right side' is BEFORE content.
        echo '<div class="right side">';
        echo '</div>';
        echo '<div class="content">';
        echo $OUTPUT->heading(get_string('orphanedactivities'), 3, 'sectionname');
        print_section($course, $thissection, $mods, $modnamesused);
        echo '</div>';
        echo "</li>\n";
    }
}


echo "</ul>\n";


}else{  //not administrator here////

// Note, an ordered list would confuse - "1" could be the clipboard or summary.
echo "<ul class='topics'>\n";

/// If currently moving a file then show the current clipboard
if (ismoving($course->id)) {
    $stractivityclipboard = strip_tags(get_string('activityclipboard', '', $USER->activitycopyname));
    $strcancel= get_string('cancel');
    echo '<li class="clipboard">';
    echo $stractivityclipboard.'&nbsp;&nbsp;(<a href="mod.php?cancelcopy=true&amp;sesskey='.sesskey().'">'.$strcancel.'</a>)';
    echo "</li>\n";
}

/// Print Section 0 with general activities

$section = 0;
$thissection = $sections[$section];
unset($sections[0]);

if($USER->id == '2'){
if ($thissection->summary or $thissection->sequence or $PAGE->user_is_editing()) {

    // Note, no need for a 'left side' cell or DIV.
    // Note, 'right side' is BEFORE content.	
    echo '<li id="section-0" class="section main clearfix" >';
    echo '<div class="left side">&nbsp;</div>';
    echo '<div class="right side" >&nbsp;</div>';
    echo '<div class="content">';	
	
	echo "<div style='font-size:1.5em; font-weight:bolder;'>".$COURSE->fullname."</div>";
	//ADDED BY arizanabdullah ON 21/12/2011
	//echo '<p><span style="font-size: large;"><strong>';
	//echo ucwords(strtolower($course->fullname));
	//echo '</strong></span></p>';
	//end ADDED BY ARIZANABDULLAH ON 21/12/2011	
	
    if (!is_null($thissection->name)) {
        //echo $OUTPUT->heading($thissection->name, 3, 'sectionname'); //remove by arizan abdullah
    }
	
    echo '<div class="summary">';	
    $coursecontext = get_context_instance(CONTEXT_COURSE, $course->id);
    $summarytext = file_rewrite_pluginfile_urls($thissection->summary, 'pluginfile.php', $coursecontext->id, 'course', 'section', $thissection->id);
    $summaryformatoptions = new stdClass();
    $summaryformatoptions->noclean = true;
    $summaryformatoptions->overflowdiv = true;
    echo format_text($summarytext, $thissection->summaryformat, $summaryformatoptions);

    if ($PAGE->user_is_editing() && has_capability('moodle/course:update', $coursecontext)) {
        echo '<a title="'.$streditsummary.'" '.
             ' href="editsection.php?id='.$thissection->id.'"><img src="'.$OUTPUT->pix_url('t/edit') . '" '.
             ' class="icon edit" alt="'.$streditsummary.'" /></a>';
    }
    echo '</div>';

    print_section($course, $thissection, $mods, $modnamesused);
    
    //added by arizanabdullah on 16052012
   include('../manualdbconfig.php');
   
    $sqlD="SELECT * FROM {$CFG->prefix}role_assignments WHERE userid='".$USER->id."' AND contextid='1'";
    $sqlQ=mysql_query($sqlD);
    $rs=mysql_fetch_array($sqlQ);    

    if($COURSE->id == '12'){ //exam and question bank section on course
	
		$examsoftware=get_string('backup');
		$exam_newsoftware='Generate new exam software';
		$generate_software = new moodle_url('/backup/backup.php', array('id'=>$COURSE->id));	
		
        if($rs['roleid']=='10' || ($USER->id == '2')){
            
			$sqlOperation="SELECT *, date_format(from_unixtime(timemodified), '%Y-%m-%d') as timemodified FROM {$CFG->prefix}files WHERE component='backup' ORDER BY id DESC";

            $sqlRw=mysql_query($sqlOperation);
            $rs1=mysql_fetch_array($sqlRw);
            
            $threedayOn = date('Y-m-d',strtotime($rs1['timemodified'] . " + 1 day"));
			if(($rs1['timecreated']<=date('Y-m-d'))&& (date('Y-m-d')<=$threedayOn)){
            
            echo 'Date created token: '.$rs1['timemodified'].' <br/>Date today: '.date('Y-m-d');   
            echo '<br/> Date expired: '.$threedayOn; 
                
            echo '<br/><br/>';      
            
            echo $OUTPUT->container_start();
            $treeview_options = array();
            $treeview_options['filecontext'] = $context;
            $treeview_options['currentcontext'] = $context;
            $treeview_options['component']   = 'backup';
            $treeview_options['context']     = $context;
            $treeview_options['filearea']    = 'course';
            $renderer = $PAGE->get_renderer('core', 'backup');
            echo $renderer->backup_files_viewer($treeview_options);
            echo $OUTPUT->container_end(); 
            echo '<br/>';
			
			if($USER->id == '2'){
				//echo '<a href="'.$generate_software.'" title="click here to '.$exam_newsoftware.'">'.$exam_newsoftware.'</a><br/><br/>';
				echo html_writer::start_tag('div', array('style'=>'float:left;'));
				echo $OUTPUT->single_button($generate_software, $exam_newsoftware, 'post');
				echo html_writer::end_tag('div');
				echo '<br/><br/>';
			}
			
			}else{ 
				echo '- No files to download. <br/><br/>';
				if($USER->id == '2'){
					//echo '<a href="'.$generate_software.'" title="click here to '.$examsoftware.'">'.$examsoftware.'</a><br/><br/>';
					echo html_writer::start_tag('div', array('style'=>'float:left;'));
					echo $OUTPUT->single_button($generate_software, $examsoftware, 'post');
					echo html_writer::end_tag('div');
					echo '<br/><br/>';
				}				
			}
        //end by arizanabdullah on 16052012
        }
    }    

    if ($PAGE->user_is_editing()) {
        print_section_add_menus($course, $section, $modnames);
    }

    echo '</div>';
    echo "</li>\n";
}
}

/// Now all the normal modules by topic
/// Everything below uses "section" terminology - each "section" is a topic.

if($rs['roleid']!='10'){ //add by arizan

$timenow = time();
$section = 1;
$sectionmenu = array();

echo '<table border="0" width="100%" style="margin:0px;">';
echo '<td width="80%" style="color:#fff;background-color:#56b3c9;border: 1px solid #E5E5E5;"> <b>Modules</b> </td>';
echo '<td width="20%" style="color:#fff;background-color:#56b3c9;text-align:center;border: 1px solid #E5E5E5;"> <b>Progress</b> </td>';	
while ($section <= $course->numsections) {
	
    if (!empty($sections[$section])) {
        $thissection = $sections[$section];

    } else {
        $thissection = new stdClass;
        $thissection->course  = $course->id;   // Create a new section structure
        $thissection->section = $section;
        $thissection->name    = null;
        $thissection->summary  = '';
        $thissection->summaryformat = FORMAT_HTML;
        $thissection->visible  = 1;
        $thissection->id = $DB->insert_record('course_sections', $thissection);
    }

    $showsection = (has_capability('moodle/course:viewhiddensections', $context) or $thissection->visible or !$course->hiddensections);

    if (!empty($displaysection) and $displaysection != $section) {  // Check this topic is visible
        if ($showsection) {
            $sectionmenu[$section] = get_section_name($course, $thissection);
        }
        $section++;
        continue;
    }

    if ($showsection) {

        $currenttopic = ($course->marker == $section);

        $currenttext = '';
        if (!$thissection->visible) {
            $sectionstyle = ' hidden';
        } else if ($currenttopic) {
            $sectionstyle = ' current';
            $currenttext = get_accesshide(get_string('currenttopic','access'));
        } else {
            $sectionstyle = '';
        }
		echo '<tr><td width="80%" style="padding:0px;border: 1px solid #E5E5E5;">';
        echo '<li style="border: none;margin:0px;" id="section-'.$section.'" class="section main clearfix'.$sectionstyle.'" >'; //'<div class="left side">&nbsp;</div>';

            echo '<div class="left side">'.$currenttext.$section.'</div>';
        // Note, 'right side' is BEFORE content.
        echo '<div class="right side">';

        if ($displaysection == $section) {    // Show the zoom boxes
            echo '<a href="view.php?id='.$course->id.'&amp;topic=0#section-'.$section.'" title="'.$strshowalltopics.'">'.
                 '<img src="'.$OUTPUT->pix_url('i/all') . '" class="icon" alt="'.$strshowalltopics.'" /></a><br />';
        } else {
            $strshowonlytopic = get_string("showonlytopic", "", $section);
            echo '<a href="view.php?id='.$course->id.'&amp;topic='.$section.'" title="'.$strshowonlytopic.'">'.
                 '<img src="'.$OUTPUT->pix_url('i/one') . '" class="icon" alt="'.$strshowonlytopic.'" /></a><br />';
        }

        if ($PAGE->user_is_editing() && has_capability('moodle/course:update', get_context_instance(CONTEXT_COURSE, $course->id))) {

            if ($course->marker == $section) {  // Show the "light globe" on/off
                echo '<a href="view.php?id='.$course->id.'&amp;marker=0&amp;sesskey='.sesskey().'#section-'.$section.'" title="'.$strmarkedthistopic.'">'.'<img src="'.$OUTPUT->pix_url('i/marked') . '" alt="'.$strmarkedthistopic.'" /></a><br />';
            } else {
                echo '<a href="view.php?id='.$course->id.'&amp;marker='.$section.'&amp;sesskey='.sesskey().'#section-'.$section.'" title="'.$strmarkthistopic.'">'.'<img src="'.$OUTPUT->pix_url('i/marker') . '" alt="'.$strmarkthistopic.'" /></a><br />';
            }

            if ($thissection->visible) {        // Show the hide/show eye
                echo '<a href="view.php?id='.$course->id.'&amp;hide='.$section.'&amp;sesskey='.sesskey().'#section-'.$section.'" title="'.$strtopichide.'">'.
                     '<img src="'.$OUTPUT->pix_url('i/hide') . '" class="icon hide" alt="'.$strtopichide.'" /></a><br />';
            } else {
                echo '<a href="view.php?id='.$course->id.'&amp;show='.$section.'&amp;sesskey='.sesskey().'#section-'.$section.'" title="'.$strtopicshow.'">'.
                     '<img src="'.$OUTPUT->pix_url('i/show') . '" class="icon hide" alt="'.$strtopicshow.'" /></a><br />';
            }
            if ($section > 1) {                       // Add a arrow to move section up
                echo '<a href="view.php?id='.$course->id.'&amp;random='.rand(1,10000).'&amp;section='.$section.'&amp;move=-1&amp;sesskey='.sesskey().'#section-'.($section-1).'" title="'.$strmoveup.'">'.
                     '<img src="'.$OUTPUT->pix_url('t/up') . '" class="icon up" alt="'.$strmoveup.'" /></a><br />';
            }

            if ($section < $course->numsections) {    // Add a arrow to move section down
                echo '<a href="view.php?id='.$course->id.'&amp;random='.rand(1,10000).'&amp;section='.$section.'&amp;move=1&amp;sesskey='.sesskey().'#section-'.($section+1).'" title="'.$strmovedown.'">'.
                     '<img src="'.$OUTPUT->pix_url('t/down') . '" class="icon down" alt="'.$strmovedown.'" /></a><br />';
            }
        }
        echo '</div>';

        echo '<div class="content">';
        if (!has_capability('moodle/course:viewhiddensections', $context) and !$thissection->visible) {   // Hidden for students
            echo get_string('notavailable');
        } else {
            if (!is_null($thissection->name)) {
                echo $OUTPUT->heading($thissection->name, 3, 'sectionname');
            }
            echo '<div class="summary">';
            if ($thissection->summary) {
                $coursecontext = get_context_instance(CONTEXT_COURSE, $course->id);
                $summarytext = file_rewrite_pluginfile_urls($thissection->summary, 'pluginfile.php', $coursecontext->id, 'course', 'section', $thissection->id);
                $summaryformatoptions = new stdClass();
                $summaryformatoptions->noclean = true;
                $summaryformatoptions->overflowdiv = true;
                echo format_text($summarytext, $thissection->summaryformat, $summaryformatoptions);
            } else {
               echo '&nbsp;';
            }

            if ($PAGE->user_is_editing() && has_capability('moodle/course:update', get_context_instance(CONTEXT_COURSE, $course->id))) {
                echo ' <a title="'.$streditsummary.'" href="editsection.php?id='.$thissection->id.'">'.
                     '<img src="'.$OUTPUT->pix_url('t/edit') . '" class="icon edit" alt="'.$streditsummary.'" /></a><br /><br />';
            }
            echo '</div>';

            print_section($course, $thissection, $mods, $modnamesused);
            echo '<br />';
            if ($PAGE->user_is_editing()) {
                print_section_add_menus($course, $section, $modnames);
            }
        }

        echo '</div>';
        echo "</li>\n";
		echo "</td>";
		echo '<td width="20%" valign="top" style="border: 1px solid #E5E5E5;padding-top:0px;">';
		//echo '<li id="section-'.$section.'" style="background:none;" class="section main clearfix'.$sectionstyle.'" >';
		echo '<div class="summary"> </div>';
		echo '<div class="content" style="padding: 10px;margin:0px">';
		echo '<div class="mod-indent" style="text-align:center;">';
		$sqlt=mysql_query("SELECT * FROM mdl_cifacourse_sections WHERE section!='0' AND course='".$COURSE->id."' AND sequence!=''");
		/* $ss=mysql_num_rows($sqlt);
		if($ss!='0'){ */
			while($sb=mysql_fetch_array($sqlt)){
			if($section==$sb['section']){
			echo 'In Progress <br/>(0%)';
			}
			}
		/* } */
		echo '</div>';
		echo '</div>';
		//echo "</li>\n";
		echo '</td>';		
		echo "</tr>";
    }
	
    unset($sections[$section]);
    $section++;
}
echo '</table>';
} echo '<div style="min-height:58px;"></div>'; //add by aa
if (!$displaysection and $PAGE->user_is_editing() and has_capability('moodle/course:update', get_context_instance(CONTEXT_COURSE, $course->id))) {
    // print stealth sections if present
    $modinfo = get_fast_modinfo($course);
    foreach ($sections as $section=>$thissection) {
        if (empty($modinfo->sections[$section])) {
            continue;
        }

        echo '<li id="section-'.$section.'" class="section main clearfix orphaned hidden">'; //'<div class="left side">&nbsp;</div>';

        echo '<div class="left side">';
        echo '</div>';
        // Note, 'right side' is BEFORE content.
        echo '<div class="right side">';
        echo '</div>';
        echo '<div class="content">';
        echo $OUTPUT->heading(get_string('orphanedactivities'), 3, 'sectionname');
        print_section($course, $thissection, $mods, $modnamesused);
        echo '</div>';
        echo "</li>\n";
    }
}
echo "</ul>\n";
}


if (!empty($sectionmenu)) {
    $select = new single_select(new moodle_url('/course/view.php', array('id'=>$course->id)), 'topic', $sectionmenu);
    $select->label = get_string('jumpto');
    $select->class = 'jumpmenu';
    $select->formid = 'sectionmenu';
    echo $OUTPUT->render($select);
}
