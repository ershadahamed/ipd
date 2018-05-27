<?php

    require_once('../config.php');
	include('../manualdbconfig.php');
	require_once('../functiontime.php');
    require_once($CFG->libdir.'/adminlib.php');
    require_once($CFG->dirroot.'/user/filters/lib.php');

    $delete       = optional_param('delete', 0, PARAM_INT);
    $confirm      = optional_param('confirm', '', PARAM_ALPHANUM);   //md5 confirmation hash
    $confirmuser  = optional_param('confirmuser', 0, PARAM_INT);
    $sort         = optional_param('sort', 'name', PARAM_ALPHA);
    $dir          = optional_param('dir', 'ASC', PARAM_ALPHA);
    $page         = optional_param('page', 0, PARAM_INT);
    $perpage      = optional_param('perpage', 30, PARAM_INT);        // how many per page
    $ru           = optional_param('ru', '2', PARAM_INT);            // show remote users
    $lu           = optional_param('lu', '2', PARAM_INT);            // show local users
    $acl          = optional_param('acl', '0', PARAM_INT);           // id of user to tweak mnet ACL (requires $access)

    admin_externalpage_setup('editusers');

    $sitecontext = get_context_instance(CONTEXT_SYSTEM);
    $site = get_site();

    if (!has_capability('moodle/user:update', $sitecontext) and !has_capability('moodle/user:delete', $sitecontext)) {
        print_error('nopermissions', 'error', '', 'edit/delete users');
    }

	$imgsrc=$CFG->wwwroot. '/image/edit.png';
	$imgsrcdelete=$CFG->wwwroot. '/image/delete.png';
	$stredit = '<img src="'.$imgsrc.'" width="25" title="'.get_string('edit').'" alt="'.get_string('edit').'">';
	$strdelete = '<img src="'.$imgsrcdelete.'" width="25" title="'.get_string('delete').'" alt="'.get_string('delete').'">';
    $strdeletecheck = get_string('deletecheck');
    $strshowallusers = get_string('showallusers');

    if (empty($CFG->loginhttps)) {
        $securewwwroot = $CFG->wwwroot;
    } else {
        $securewwwroot = str_replace('http:','https:',$CFG->wwwroot);
    }

    $returnurl = "$CFG->wwwroot/$CFG->admin/user.php";

    if ($confirmuser and confirm_sesskey()) {
        if (!$user = $DB->get_record('user', array('id'=>$confirmuser))) {
            print_error('nousers');
        }

        $auth = get_auth_plugin($user->auth);

        $result = $auth->user_confirm($user->username, $user->secret);

        if ($result == AUTH_CONFIRM_OK or $result == AUTH_CONFIRM_ALREADY) {
            redirect($returnurl);
        } else {
            echo $OUTPUT->header();
            redirect($returnurl, get_string('usernotconfirmed', '', fullname($user, true)));
        }

    } else if ($delete and confirm_sesskey()) {              // Delete a selected user, after confirmation

        require_capability('moodle/user:delete', $sitecontext);

        $user = $DB->get_record('user', array('id'=>$delete), '*', MUST_EXIST);

        if (is_siteadmin($user->id)) {
            print_error('useradminodelete', 'error');
        }

        if ($confirm != md5($delete)) {
            echo $OUTPUT->header();
            $fullname = fullname($user, true);
            echo $OUTPUT->heading(get_string('deleteuser', 'admin'));
            $optionsyes = array('delete'=>$delete, 'confirm'=>md5($delete), 'sesskey'=>sesskey());
            echo $OUTPUT->confirm(get_string('deletecheckfull', '', "'$fullname'"), new moodle_url('user.php', $optionsyes), 'user.php');
            echo $OUTPUT->footer();
            die;
        } else if (data_submitted() and !$user->deleted) {
            if (delete_user($user)) {
                session_gc(); // remove stale sessions
                redirect($returnurl);
            } else {
                session_gc(); // remove stale sessions
                echo $OUTPUT->header();
                echo $OUTPUT->notification($returnurl, get_string('deletednot', '', fullname($user, true)));
            }
        }
    } else if ($acl and confirm_sesskey()) {
        if (!has_capability('moodle/user:delete', $sitecontext)) {
            // TODO: this should be under a separate capability
            print_error('nopermissions', 'error', '', 'modify the NMET access control list');
        }
        if (!$user = $DB->get_record('user', array('id'=>$acl))) {
            print_error('nousers', 'error');
        }
        if (!is_mnet_remote_user($user)) {
            print_error('usermustbemnet', 'error');
        }
        $accessctrl = strtolower(required_param('accessctrl', PARAM_ALPHA));
        if ($accessctrl != 'allow' and $accessctrl != 'deny') {
            print_error('invalidaccessparameter', 'error');
        }
        $aclrecord = $DB->get_record('mnet_sso_access_control', array('username'=>$user->username, 'mnet_host_id'=>$user->mnethostid));
        if (empty($aclrecord)) {
            $aclrecord = new stdClass();
            $aclrecord->mnet_host_id = $user->mnethostid;
            $aclrecord->username = $user->username;
            $aclrecord->accessctrl = $accessctrl;
            $DB->insert_record('mnet_sso_access_control', $aclrecord);
        } else {
            $aclrecord->accessctrl = $accessctrl;
            $DB->update_record('mnet_sso_access_control', $aclrecord);
        }
        $mnethosts = $DB->get_records('mnet_host', null, 'id', 'id,wwwroot,name');
        redirect($returnurl);
    }

    // create the user filter form
    $ufiltering = new user_filtering();
    echo $OUTPUT->header();

	
//added by arizan abdullah 20121126
	$sqlquery=mysql_query("SELECT * FROM mdl_cifauser ORDER BY id DESC");
	$sqlrow=mysql_fetch_array($sqlquery);
	
	$qryuserrole=mysql_query("SELECT * FROM mdl_cifarole WHERE name='".$sqlrow['usertype']."'");
	$rowuserrole=mysql_fetch_array($qryuserrole);	
	
	$usercandidateid=$sqlrow['id'];

	if($rowuserrole['id'] == '5'){ $usergroup='A'; } 		//candidate
	else if($rowuserrole['id'] == '3'){ $usergroup='G'; } 	//trainer
	else if($rowuserrole['id'] == '4'){ $usergroup='I'; } 	//exam editor
	else if($rowuserrole['id'] == '6'){ $usergroup='E'; } 	//guest
	else if($rowuserrole['id'] == '10'){ $usergroup='D'; }	//exam center admin
	else if($rowuserrole['id'] == '11'){ $usergroup='H'; }	//examiner
	else if($rowuserrole['id'] == '12'){ $usergroup='C'; }	//business partner
	else if($rowuserrole['id'] == '13'){ $usergroup='B'; }	//hr admin
	
	$userusername=strtolower($usergroup.''.$sqlrow['username'].''.$sqlrow['country']);
	$usertraineeid=$usergroup.''.$sqlrow['traineeid'].''.$sqlrow['country'];	
	
	$harini=strtotime('now');
	$countstring=strlen($sqlrow['username']);
	if($countstring < '8'){ 
		$updatemaklumat=mysql_query("UPDATE mdl_cifauser SET username='".$userusername."', traineeid='".$usertraineeid."' WHERE id='".$usercandidateid."'");
		
		if($rowuserrole['id']!='5'){
			//assign users to whole system
			$roleassuser=mysql_query("INSERT INTO mdl_cifarole_assignments SET roleid='".$rowuserrole['id']."', contextid='1', userid='".$usercandidateid."', timemodified='".$harini."', modifierid='2'");
		}else{
			//set candidate default SHAPE IPD
			$userprogram=mysql_query("INSERT INTO mdl_cifauser_program SET userid='".$usercandidateid."', programid='1', programname='Shape Ipd'");
		}
	}
//ended by arizan abdullah		
	
	
    // Carry on with the user listing

    //$columns = array("firstname", "lastname", "email", "city", "country", "lastaccess");
	$columns = array("firstname", "lastname", "dob", "email", "traineeid", /*"city",*/ "country", "usertype", "lastaccess");

    foreach ($columns as $column) {
        $string[$column] = get_string("$column");
        if ($sort != $column) {
            $columnicon = "";
            if ($column == "lastaccess") {
                $columndir = "DESC";
            } else {
                $columndir = "ASC";
            }
        } else {
            $columndir = $dir == "ASC" ? "DESC":"ASC";
            if ($column == "lastaccess") {
                $columnicon = $dir == "ASC" ? "up":"down";
            } else {
                $columnicon = $dir == "ASC" ? "down":"up";
            }
            $columnicon = " <img src=\"" . $OUTPUT->pix_url('t/' . $columnicon) . "\" alt=\"\" />";

        }
        $$column = "<a href=\"user.php?sort=$column&amp;dir=$columndir\">".$string[$column]."</a>$columnicon";
    }

    if ($sort == "name") {
        $sort = "firstname";
    }

    list($extrasql, $params) = $ufiltering->get_sql_filter();
    $users = get_users_listing($sort, $dir, $page*$perpage, $perpage, '', '', '', $extrasql, $params);
    $usercount = get_users(false);
    $usersearchcount = get_users(false, '', false, null, "", '', '', '', '', '*', $extrasql, $params);

    if ($extrasql !== '') {
        echo $OUTPUT->heading("$usersearchcount / $usercount ".get_string('users'));
        $usercount = $usersearchcount;
    } else {
        echo $OUTPUT->heading("$usercount ".get_string('users'));
    }

    $strall = get_string('all');

    $baseurl = new moodle_url('user.php', array('sort' => $sort, 'dir' => $dir, 'perpage' => $perpage));
    echo $OUTPUT->paging_bar($usercount, $page, $perpage, $baseurl);

    flush();


    if (!$users) {
        $match = array();
        echo $OUTPUT->heading(get_string('nousersfound'));

        $table = NULL;

    } else {

        $countries = get_string_manager()->get_list_of_countries(false);
        if (empty($mnethosts)) {
            $mnethosts = $DB->get_records('mnet_host', null, 'id', 'id,wwwroot,name');
        }

        foreach ($users as $key => $user) {
            if (isset($countries[$user->country])) {
                $users[$key]->country = $countries[$user->country];
            }
        }
        if ($sort == "country") {  // Need to resort by full country name, not code
            foreach ($users as $user) {
                $susers[$user->id] = $user->country;
            }
            asort($susers);
            foreach ($susers as $key => $value) {
                $nusers[] = $users[$key];
            }
            $users = $nusers;
        }

        $override = new stdClass();
        $override->firstname = 'firstname';
        $override->lastname = 'lastname';
        $fullnamelanguage = get_string('fullnamedisplay', '', $override);
        if (($CFG->fullnamedisplay == 'firstname lastname') or
            ($CFG->fullnamedisplay == 'firstname') or
            ($CFG->fullnamedisplay == 'language' and $fullnamelanguage == 'firstname lastname' )) {
            $fullnamedisplay = "$firstname / $lastname";
        } else { // ($CFG->fullnamedisplay == 'language' and $fullnamelanguage == 'lastname firstname')
            $fullnamedisplay = "$lastname / $firstname";
        }

		$table = new html_table();
        $table->head = array ($fullnamedisplay, $dob, $email, $traineeid, /*$city,*/ $country, $usertype, $lastaccess, "Edit", "Delete", "Misc");
        $table->align = array ("left", "center", "left", "left", "left", "left", "center", "center");
        $table->width = "95%";
        foreach ($users as $user) {
            if (isguestuser($user)) {
                continue; // do not display guest here
            }

            if ($user->id == $USER->id or is_siteadmin($user)) {
                $deletebutton = "";
            } else {
                if (has_capability('moodle/user:delete', $sitecontext)) {
                   // $deletebutton = "<a href=\"user.php?delete=$user->id&amp;sesskey=".sesskey()."\">$strdelete</a>";
					$deletebutton = "<a href=\"user.php?delete=$user->id&amp;sesskey=".sesskey()."\">
										".$strdelete."
									</a>";
                } else {
                    $deletebutton ="";
                }
            }

            if (has_capability('moodle/user:update', $sitecontext) and (is_siteadmin($USER) or !is_siteadmin($user)) and !is_mnet_remote_user($user)) {
                $editbutton = "<a href=\"$securewwwroot/user/editadvanced.php?id=$user->id&amp;course=$site->id\">$stredit</a>";
				//$editbutton = "<a href=\"$securewwwroot/user/edit.php?id=$user->id&amp;course=$site->id\">$stredit</a>";
                if ($user->confirmed == 0) {
                    $confirmbutton = "<a href=\"user.php?confirmuser=$user->id&amp;sesskey=".sesskey()."\">" . get_string('confirm') . "</a>";
                } else {
					$linkconfirm=$CFG->wwwroot. "/image/yes.png";
                    $confirmbutton = '<img src="'.$linkconfirm.'" width="20" title="User already confirmed to access LMS" />';
                }
            } else {
                $editbutton ="";
                if ($user->confirmed == 0) {
                    $confirmbutton = "<span class=\"dimmed_text\">".get_string('confirm')."</span>";
                } else {
                    $confirmbutton = "";
                }
            }

            // for remote users, shuffle columns around and display MNET stuff
            if (is_mnet_remote_user($user)) {
                $accessctrl = 'allow';
                if ($acl = $DB->get_record('mnet_sso_access_control', array('username'=>$user->username, 'mnet_host_id'=>$user->mnethostid))) {
                    $accessctrl = $acl->accessctrl;
                }
                $changeaccessto = ($accessctrl == 'deny' ? 'allow' : 'deny');
                // delete button in confirm column - remote users should already be confirmed
                // TODO: no delete for remote users, for now. new userid, delete flag, unique on username/host...
                $confirmbutton = "";
                // ACL in delete column
                $deletebutton = get_string($accessctrl, 'mnet');
                if (has_capability('moodle/user:delete', $sitecontext)) {
                    // TODO: this should be under a separate capability
                    $deletebutton .= " (<a href=\"?acl={$user->id}&amp;accessctrl=$changeaccessto&amp;sesskey=".sesskey()."\">"
                            . get_string($changeaccessto, 'mnet') . " access</a>)";
                }
                // mnet info in edit column
                if (isset($mnethosts[$user->mnethostid])) {
                    $editbutton = $mnethosts[$user->mnethostid]->name;
                }
            }

            if ($user->lastaccess) {
                $strlastaccess = format_time(time() - $user->lastaccess);
            } else {
                $strlastaccess = get_string('never');
            }
			
			//add by aa
			$id=$user->id;
			
			$sql="SELECT * FROM mdl_cifauser WHERE id='$id'";
			$query=mysql_query($sql, $conn);
			$row=mysql_fetch_array($query);
				$traineeid=ucwords(strtoupper($row['traineeid']));
				$usertype=ucwords(strtolower($row['usertype']));
				//if($row['usertype']== $CFG->usertype){ echo 'hallo'; }
				$dob=unix_timestamp_to_human($row['dob']);
				//$dob=$row['dob'] + 3600*24;	
			
            $fullname = ucwords(strtolower(fullname($user, true)));

            $table->data[] = array ("<a href=\"../user/view.php?id=$user->id&amp;course=$site->id\">$fullname</a>",
                                $dob,	
								"$user->email",
								"$traineeid",
								/*"$user->city",*/
                                "$user->country",
                                $usertype,					
                                $strlastaccess,
                                $editbutton,
                                $deletebutton,
                                $confirmbutton);
        }
    }

    // add filters
    //$ufiltering->display_add();
    //$ufiltering->display_active();
	

	?>
	<fieldset style="border:1px solid #000000; width: 95%; margin-right: auto; margin-left: auto;">
		<legend style="font-weight: bold; margin: 0 10px 0 10px; padding:0 10px 0 10px;">Search users</legend>
	<?php
		echo '<div style="padding:20px; float: left; width:100%;">';
	?>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<?php echo '<div style="padding-bottom:5px;">';
		$title_search = '<b>Name / Trainee ID / Country / Usertype :</b>';
		echo $title_search;
		echo '</div>';
	?>
	<input type="text" name="searchusers" size="30" /> 
	<?php
	//list of modules exam
	echo '<select name="searchusers" onchange="this.form.submit();">';
	echo '<option value=""> Please select..</option>';
	$queryquiz=mysql_query("SELECT * FROM {$CFG->prefix}role WHERE (id!='1' AND id!='2' AND id!='4' AND id!='6' AND id!='7' AND id!='8')");
	while($qsearch=mysql_fetch_array($queryquiz)){
		echo '<option value="'.$qsearch['name'].'">'.$qsearch['name'].'</option>';
	}
	echo '</select>';
	?>	
	<input type="submit" name="submit" value="Search" />
	<?php
	if(isset($_POST['submit'])=='Search'){
		include('search_users.php');
	}
	?>
	</form></div></fieldset>
	<br/>
	<?php
	//disable by arizan abdullah
    if (has_capability('moodle/user:create', $sitecontext)) {
        //echo $OUTPUT->heading('<a href="'.$securewwwroot.'/user/editadvanced.php?id=-1">'.get_string('addnewuser').'</a>');
	}
    if (!empty($table)) {
        echo html_writer::table($table);
        echo $OUTPUT->paging_bar($usercount, $page, $perpage, $baseurl);
		
		// Print button for creating new user
		$goback='Go Back';
		echo '<center><table><tr><td>';
		echo '<input type="button" name="goback" value="'.$goback.'" ONCLICK="history.go(-1)">';
		echo '</td><td>';
		echo $OUTPUT->single_button(new moodle_url('/user/editadvanced.php?id=-1'), get_string('addnewuser'));
		echo '</td></tr></table></center>';
    }
    echo $OUTPUT->footer();


