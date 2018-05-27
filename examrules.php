<?php	
    require_once('config.php');
	require_once('manualdbconfig.php');
    // require_once('lib.php');
    // require_once($CFG->dirroot.'/mod/forum/lib.php');
    // require_once($CFG->libdir.'/completionlib.php');
	
	
	$site = get_site();
	
	$examguidetitle=ucwords(strtolower(get_string('eguide')));
	$title="$SITE->shortname: ".$examguidetitle;
	$PAGE->set_title($title);
	$PAGE->set_heading($site->fullname);
	//$PAGE->set_pagelayout('examguide');
			
	if (isloggedin()) {
	$erules=get_string('erules');
	echo '<div style="width:90%; margin:3em auto;">';
	echo $OUTPUT->heading($erules, 2, 'headingblock header');
?>
<script language="javascript">
var isNS = (navigator.appName == "Netscape") ? 1 : 0;
  if(navigator.appName == "Netscape")
     document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
  function mischandler(){
   return false;
 }
  function mousehandler(e){
     var myevent = (isNS) ? e : event;
     var eventbutton = (isNS) ? myevent.which : myevent.button;
    if((eventbutton==2)||(eventbutton==3)) return false;
 }
 document.oncontextmenu = mischandler;
 document.onmousedown = mousehandler;
 document.onmouseup = mousehandler;
function killCopy(e){
    return false
}
function reEnable(){
    return true
}
document.onselectstart = new Function ("return false")
if (window.sidebar){
    document.onmousedown=killCopy
    document.onclick=reEnable
}
</script> 

<p style="text-align:justify;">Please read these rules and regulations carefully. These rules are used as guide for candidate in ensuring smooth process for examination booking and on examination day. In taking the examination, SHAPE&reg; adheres to the policy and rules of the exam center prior to ours. Thus, candidates are highly recommended to understand and adhere to the rules of the respective exam center as each center may have different policy and rules especially pertaining to exam date booking, admission to the exam room, conduct during exam and absence from the examination. </p>

<ol>
  <li><strong>Exam Entry &amp; Exam Token Validation </strong><strong> </strong>
    <ol type="a">
      <li>Please note that active examination token is a <strong>MUST</strong> to sit for the CIFA&#8482; exam.  CIFA&#8482; Examination token is valid for 12 months from the date of  curriculum purchase. </li>
      <li>The first CIFA&#8482; examination token is part  of the CIFA&#8482; curriculum purchased online. Thus, no additional fee  is required. Candidate may proceed to book the examination date with the  accredited exam center. Please <strong><u>contact us</u></strong><strong> </strong>for  the list of exam centers. </li>
      <li>For exam re-sit, candidates are advised to undergo the  exam re-sit entry online prior to booking the exam date with the exam  center.  Please refer to <a href="http://www.LearnCIFA.com/faq">www.LearnCIFA.com/faq</a> for more information. </li>
      <li>For re-sit token the validity of the token is 6  months.</li>
    </ol><br/>
  </li>
  <li><strong>Admission to the Exam Room </strong><strong> </strong>
    <ol type="a">
      <li>You must bring the following to gain entry to the exam  room:
        <ul type="disc">
          <li>A form of photographic Identification with your name  and signature printed on it.</li>
          <li>Bring also a blue or black pen, a pencil and a calculator.</li>
        </ul>
      </li>
      <li>You should be at the exam center at least fifteen  minutes before the exam starts for candidate verification and exam briefing.</li>
    </ol>
  </li><br/>
  <li><strong>Absence from Examination </strong></li>

<blockquote>
  <p>It is the responsibility of the candidate to ensure they are fit on the  examination day. Therefore, candidate should understand and adhere to the rules  and policies of the exam centers in case of emergency and serious medical needs  which require candidate absent from the examination.</p>
  <p>Absence on the examination day without the permission of the respective  exam center results in expiry of exam token. To attempt the exam, candidates  are required to undergo the re-sit exam entry online and pay for the exam  re-sit.</p>
</blockquote>

  <li><strong>Permitted exam materials </strong><strong> </strong>
    <ol type="a">
      <li>Any personal belongings such as briefcases, mobile  phones, books, dictionaries, revision notes or written material of any kind  must be left in an area designated by the Invigilators. They should not, under  any circumstances, be left near your desk. Neither SHAPE® nor the examination  center will be responsible for any loss or damage which might be sustained to  your property.</li>
      <li>You must switch off all mobile phones prior to  entering the exam room.</li>
      <li>You may bring a bottle of water into the exam room.</li>
    </ol>
  </li><br/>
  <li><strong>Conduct during Exams </strong><strong> </strong>
    <ol type="a">
      <li>Since the exam is computer based, you will not be able  to pause during the exam.</li>
      <li>If you need to leave the room to go to the toilet you  must get permission from the Invigilator.</li>
      <li>Eating, unless for medical reasons, is not permitted  in the exam room.</li>
      <li>Smoking is not permitted.</li>
      <li>If you contravene exam rules by, for example cheating,  helping another candidate to cheat or by having materials or items with you  that could give you an unfair advantage, you will be reported to CIFA&#8482;  Academic Board. This is likely to affect your exam result. It may also result  in SHAPE® taking disciplinary action against you. The following are deemed to  be examples of contravention of exam rules:
        <ul type="disc">
          <li>Having any book, notes or documents on you at any time  during the exam</li>
          <li>Having any book, notes or documents in a situation  which suggests you could have used them during the exam</li>
          <li>Talking to, copying from, or in any way communicating  with, another candidate</li>
          <li>Using a mobile phone, including the calculator  function</li>
          <li>Leaving the exam room without the permission of an  invigilator</li>
          <li>Removing whether used or blank papers from the exam  room, during or after the exam.</li>
        </ul>
        <blockquote>
          <p><strong><em>	* This list is not exhaustive. </em></strong></p>
        </blockquote>
      </li>
      <li>Disruptive conduct during exams will not be permitted.  The Invigilator has the right to terminate the exam of any candidate whose  behavior is disruptive and to have the candidate escorted from the exam room.  In such cases a full report will be made to the CIFA&#8482; Academic  Board.</li>
    </ol>
  </li>

  <br/>
  <li><strong>At the end of the exam </strong>
    <ol type="a">
      <li>You may end the  exam you are undertaking if, for example, you have completed all questions. The  exam has &lsquo;FINISH&rsquo; icons to facilitate such request.</li>
      <li>Alternatively, when  the pre-determined examination time allocation has expired, the software will  automatically end the exam.</li>
      <li>On concluding the  exam, the system will display your results on the computer screen. All results  displayed on screen must be witnessed by the invigilator. The invigilator is  required to print a copy of the result summary and either give or post it to  you.</li>
      <li>This result will  then be retrieved by the center and your results be will uploaded to your  workspace area within 14 days after your examination.</li>
    </ol>
  </li><br/>
  
  <li><strong>Liability </strong> <br />
  SHAPE&reg; or the Exam  Center will not be liable for any loss of, theft of or damage to personal  belongings left in or outside the exam room. Any personal items brought to the  exam are done so at the owner&rsquo;s risk.</li>
</ol>
<p>For more information, please <a href="#" target="_blank"><u><strong>contact us</strong></u></a>.</p>
</div><?php }else{ echo '<div style="margin:2em auto"><h3>'.get_string('examrulesloggin').'</h3></div>'; } ?>