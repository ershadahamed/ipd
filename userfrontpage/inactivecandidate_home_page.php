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

/*.col-md-9 { width:100%;}*/
.widget-app .link-list {
    margin: 0px;
}

.widget-app .widget-app-header {
    margin: 0px;
}

</style>
<?php 
	//new curiculum/ipd course
	$today=date('d-m-Y H:i:s',strtotime('now'));
	
	//IPD candidate 
	$IPDstatement=" mdl_cifauser a, mdl_cifauser_program b WHERE a.id=b.userid AND a.deleted!='1' AND b.programid='1' AND b.userid='".$USER->id."'";
	$selIPD=mysql_query("SELECT * FROM {$IPDstatement}");
	$cIPD=mysql_num_rows($selIPD); 
	
	//header menu//
	$link_myaccount='<a class="link" href="'.$CFG->wwwroot.'/user/profile.php?id='.$USER->id.'">';
	$link_mytraining='<a class="link" href="'.$CFG->wwwroot.'/coursesindex.php?id='.$USER->id.'">';
	$link_mycommunity='<a class="link" href="'.$CFG->wwwroot.'/userfrontpage/mycommunitypage.php?id='.$USER->id.'">';
	$link_mockexam='<a class="link" href="'.$CFG->wwwroot.'/course/mock_exam.php?id='.$USER->id.'">';
	$ahref_close='</a>';
?>
<div id="main-app-body">
    <div class="container">

        <div class="row">
            <div class="col-md-9"> 
				<?php 					
					$selectstatement2=mysql_query("SELECT * FROM mdl_cifacandidates WHERE traineeid='".$USER->traineeid."'");
					$ssql2=mysql_num_rows($selectstatement2);							
				?>				
                <div class="row margin-lg-bottom">
                    <div class="col-md-4">
                        <div class="widget-app" style="padding:0px;">
							<div class="widget-app-header" class="title" style="background-image: url('ui/images/theme-button-white_h.png'); padding:10px 12px">
                                <div class="title"><?=$link_myaccount.get_string('myaccount').$ahref_close;?></div>
                            </div><!-- .widget-app-header -->
                            <div class="widget-app-body" style="padding:0px; 12px 12px">
                                <div class="link-list">
                                    <ul class="list">
                                        <li class="item"><a class="link" href="<?php echo $CFG->wwwroot.'/user/profile.php?id='.$USER->id;?>">
											<?=get_string('profile');?></a></li>
                                        <!--li class="item"><a class="link" href="<?php //echo $CFG->wwwroot.'/login/change_password.php?id=1'; ?>">
											<?//=get_string('changepassword');?></a></li>
                                        <li class="item  item-disabled"><a class="link" href="#"><?//=get_string('communicationpreferences');?></a></li-->		
                                    </ul>
                                </div><!-- .link-list -->
                            </div><!-- .widget-app-body -->
                        </div><!-- .widget-app -->
                    </div><!-- .col-md-4 -->
                    <div class="col-md-4">
                        <div class="widget-app" style="padding:0px;">
							<div class="widget-app-header" class="title" style="background-image: url('ui/images/theme-button-white_h.png'); padding:10px 12px">
                                <div class="title"><?=$link_mytraining.get_string('mytraining').$ahref_close;?></div>
                            </div><!-- .widget-app-header -->
                            <div class="widget-app-body" style="padding:0px; 12px 12px">
                                <div class="link-list">
                                    <ul class="list">
                                        <!--li class="item"><a class="link" href="<?php //echo $CFG->wwwroot.'/coursesindex.php?id='.$USER->id;?>"><?//=get_string('activetrainings');?></a></li>
										<li class="item"><a class="link" href="<?//=$CFG->wwwroot. '/userfrontpage/examresult_ECadmin.php?id='.$USER->id;?>"><?//=get_string('examresultcifa');?></a></li>										
										<li class="item item-disabled"><a class="link" href="#"><?//=get_string('candidateprogress');?></a></li-->
										<li class="item item-disabled"><a class="link" href="#"><?=get_string('newcourse');?></a></li>
                                    </ul>
                                </div><!-- .link-list -->
                            </div><!-- .widget-app-body -->
                        </div><!-- .widget-app -->
                    </div><!-- .col-md-4 -->
                    <div class="col-md-4">
                        <div class="widget-app" style="padding:0px;">
							<div class="widget-app-header" class="title" style="background-image: url('ui/images/theme-button-white_h.png'); padding:10px 12px">
                                <div class="title"><?=get_string('myfinancial');?></div>
                            </div><!-- .widget-app-header -->
                            <div class="widget-app-body" style="padding:0px; 12px 12px">
                                <div class="link-list">
                                    <ul class="list">
                                        <li class="item"><a class="link" href="<?=$CFG->wwwroot.'/purchasemodule.php?id='.$USER->id;?>">Reactive<?//=get_string('reactivemembership');?></a></li>
                                        <li class="item item-disabled"><a class="link" href="#"><?=get_string('paynow');?></a></li>
                                    </ul>
                                </div><!-- .link-list -->
                            </div><!-- .widget-app-body -->
                        </div><!-- .widget-app -->
                    </div><!-- .col-md-4 -->					
                </div><!-- .row -->
            </div><!-- .col-md-9 -->
            <div class="col-md-3">
                <div class="widget-app" style="padding:0px;">
                    <div class="widget-app-header" class="title" style="background-image: url('ui/images/theme-button-white_h.png'); padding:10px 12px">
                        <div>News & Update</div>
                    </div><!-- .widget-app-header -->
                    <div class="widget-app-body" style="padding:12px;">
                        <div class="post-list margin-md-top" style="margin-top:0px;">
                            <div class="post"> 
                                <div class="header"></div>
                                <div class="excerpt">
                                    <?php
										$newlink=$CFG->wwwroot.'/image/new_animated.gif';
										$snews=mysql_query("SELECT * FROM {$CFG->prefix}news_update WHERE status='0'");
										while($news=mysql_fetch_array($snews)){
											echo $news['title'].'&nbsp;<img src="'.$newlink.'" width="23"><br/>';
										}
									
										$selectnew=mysql_query("SELECT * FROM mdl_cifacourse WHERE visible='1' AND (category!='0' AND category!='3' AND category!='6') ORDER BY id DESC");																		
										$n='0'; $ab='0';
										while($serow=mysql_fetch_array($selectnew)){
											$n++; $ab++;
											$createdate=date('d-m-Y H:i:s',$serow['timecreated']);
											$expireddate=date('d-m-Y H:i:s',strtotime($createdate . " + 1 month"));
											
											$current=strtotime('now');
											$start=strtotime($createdate);
											$ex=strtotime($expireddate);
											
											if($start <= $current && $current <= $ex){
												$sc=mysql_query("SELECT * FROM mdl_cifacourse_categories WHERE id!='3' AND id='".$serow['category']."'");
												$rws=mysql_fetch_array($sc);
												$newlink=$CFG->wwwroot.'/image/new_animated.gif';
												$link_to_course=$CFG->wwwroot.'/course/view.php?id='.$serow['id'];
												$link_open="<a href='".$link_to_course."' title='Click to open ".$serow['fullname']."'>";
												$link_close="</a>";
												
												$sql_cek=mysql_query("
													Select
													  *
													From
													  mdl_cifaenrol a Inner Join
													  mdl_cifauser_enrolments b On a.id = b.enrolid
													Where
													  b.userid = '".$USER->id."' And
													  a.courseid = '".$serow['id']."'												
												");
												$c_even=mysql_num_rows($sql_cek);
												//if($c_even!='0'){
												//echo '<div class="widget-app-header"><div class="title">New Training</div></div>';
												echo $link_open.$serow['fullname'].'&nbsp;<img src="'.$newlink.'" width="23">'.$link_close.'<br/>';
												//}
											}
											
										//quiz//exam//mockexam
										$query_mock=mysql_query("SELECT * FROM mdl_cifaquiz WHERE course='".$serow['id']."'");
										$s_mock=mysql_fetch_array($query_mock);
											$mock_createdate=date('d-m-Y H:i:s',$s_mock['timemodified']);
											$mock_expireddate=date('d-m-Y H:i:s',strtotime($mock_createdate . " + 1 month"));
											
											$m_current=strtotime('now');
											$m_start=strtotime($mock_createdate);
											$m_ex=strtotime($mock_expireddate);
											
											if($m_start <= $m_current && $m_current <= $m_ex){
												$m_sc=mysql_query("SELECT * FROM mdl_cifacourse_modules WHERE course='".$s_mock['course']."' AND instance='".$s_mock['id']."'");
												$m_rws=mysql_fetch_array($m_sc);
												$newlink=$CFG->wwwroot.'/image/new_animated.gif';
												$link_to_mock=$CFG->wwwroot.'/mod/quiz/view.php?id='.$m_rws['id'];
												$m_link_open="<a href='".$link_to_mock."' title='Click to start ".$s_mock['name']."'>";
												$link_close="</a>";
												
												$sql_cek=mysql_query("
													Select
													  *
													From
													  mdl_cifaenrol a Inner Join
													  mdl_cifauser_enrolments b On a.id = b.enrolid
													Where
													  b.userid = '".$USER->id."' And
													  a.courseid = '".$serow['id']."'
													Order By
													  b.id
												");
												$c_even=mysql_num_rows($sql_cek); 
												//if($c_even!='0'){
												//if($ab=='1'){ echo '<div class="widget-app-header"><div class="title">CIFA&#8482; Events</div></div>'; }
												echo $m_link_open.$s_mock['name'].'&nbsp;<img src="'.$newlink.'" width="23">'.$link_close.'<br/>';
												//}
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