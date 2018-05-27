<?php include('config.php'); ?>
<style>
ol #myList
{
	list-style-type:lower-roman;
	text-align: justify;
}

#userpolicy
{
	width:95%;
	margin:0 auto;
	border-collapse: collapse;
	border: 2px solid rgb(152, 191, 33);
	background-color:#fff;	
}
</style>

<?php
	//to retrive back data from form
	$traineeID = $_GET['traineeID'];
	
	$firstname = $_GET['trainee_name'];
	$lastname = $_GET['lastname'];
	$address = $_GET['address'];
	$address2 = $_GET['address2'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	$province = $_GET['province'];
	$city = $_GET['city'];
	$postal = $_GET['postal'];
	$country = $_GET['country'];
	
	$coursename = $_GET['coursename'];
	$shortname = $_GET['shortname'];
	$courseid = $_GET['courseid'];
	
	$cost = $_GET['cost'];
	$currency=$_GET['currency'];
	$PaypalBusinessEmail=$_GET['PaypalBusinessEmail']; 

	?>
	<?php $link=$CFG->wwwroot. '/portal/subscribe/subscribedetails_stuck.php?traineeID='.$traineeID.'&&trainee_name='.$firstname.'&&lastname='.$lastname.'&&address='.$address.'&&address2='.$address2.'&&email='.$email.'&&phone='.$phone.'&&city='.$city.'&&province='.$province.'&&postal='.$postal.'&&country='.$country.'&&cost='.$cost.'&&currency='.$currency.'&&PaypalBusinessEmail='.$PaypalBusinessEmail.'&&coursename='.$coursename.'&&shortname='.$shortname.'&&courseid='.$courseid; ?>
<?php //echo $link; ?>
	<script language="JavaScript">
function checkfield(msg){
	pengakuan1 = 'Please tick, if you agree with the policy.';
	elem1 = document.getElementById('pengakuan1');
		if(!elem1.checked) { 
			alert(pengakuan1);
			return false; 
		} 
			//window.$coursename = "<?=$_POST['coursename']?>"; // That's for a string
            //window.opener.location.href="<?php echo $CFG->wwwroot. '/portal/subscribe/subscribedetails_loggeduser.php'; ?>";
            //self.close();			
	document.form.submit();	
	window.opener.location.href="<?=$link; ?>";
	self.close();
	return true;	
			
}
</script>
<?php //$link=$CFG->wwwroot. '/portal/subscribe/subscribedetails_loggeduser.php';?>
<form method="post" name="form"  action="<?//=$link; ?>">
<table id="userpolicy"><tr><td><br/>
<table style="width:95%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;"><tr><td>

		<input type="hidden" name="coursename" value="<?php echo $coursename; ?>">
		<input type="hidden" name="shortname" value="<?php echo $shortname; ?>">
		<input type="hidden" name="courseid" value="<?php echo $courseid; ?>">
		<input type="hidden" name="cost" value="<?php echo $cost; ?>">
		<input type="hidden" name="currency" value="<?php echo $currency;?>">
		<input type="hidden" name="PaypalBusinessEmail" value="<?php echo $PaypalBusinessEmail; ?>"/>
		<input type="hidden" name="country" value="<?php echo $country; ?>" />		

	<input type="hidden" name="traineeid" value="<?php echo $traineeID; ?>" />
	<input type="hidden" name="firstname" value="<?php echo $firstname; ?>" size="40" />
	<input type="hidden" name="lastname" size="40" value="<?php echo $lastname; ?>" />
	<input type="hidden" name="address1" size="40" value="<?php echo $address; ?>" />
	<input type="hidden" name="address2" size="40" value="<?php echo $address2; ?>" />	
	<input type="hidden" name="email" value="<?php echo $email; ?>" />
	<input type="hidden" name="phone_1" value="<?php echo $phone; ?>" />
	<input type="hidden" name="city" value="<?php echo $city; ?>" />
	<input type="hidden" name="state" value="<?php echo $province; ?>" />
	<input type="hidden" name="zip" value="<?php echo $postal; ?>" />
		

<p><strong>SHAPE<sup>TM</sup> Online Training Program User  Policies – Please Read Before Purchasing</strong><br/>
  Portal user will  need to agree and accept the policies for the SHAPE<sup>TM</sup> Online Training  Program. Please read each of these carefully before agreeing to the terms as  these policies will be strictly enforced.</p>
<ol style="list-style-type:upper-alpha; text-align: justify;">
	<li><strong>Your Subscription Begins  the First Time You Log In:</strong></li><br/>
	<ol id="myList">
		<li>All SHAPE<sup>TM</sup> online  training programs are valid for 3 months from the first time login. </li>
		<li>Within 24 hours of receiving  your purchase confirmation, you will receive an email containing your Candidate  ID and Temporary Password for you to proceed with the first time login to  activate your workspace and access the online training program.  </li>
		<li>Your subscription begins from  the first time you use the Candidate ID and Password to log in. SHAPE<sup>TM</sup>  recommends that you write down the date and time of your first login, so you  may keep track of your account expiration. </li>
		<li>SHAPE<sup>TM</sup> will send  email reminders as your subscription is expiring. </li>
		<li>Your access to the online training  program will expire as the subscription period ends. Therefore, we encourage  you to manage your time wisely and always be aware of the time you have  remaining.</li>
		<li>If you did not activate your  online subscription, your access will remain active for the period of 6 months  from the time of purchase. After which the subscription will expire and no  refund will be given for unused online training program. </li>
	</ol><br/>
	
	<li><strong>Membership &amp; CIFA  Examination Validation:</strong></li><br/>
	<ol id="myList">
		<li>Your membership is valid for a  period of 12 months from the point of enrolment. Thus, you will still have  access to your Workspace area and access to the online services and supports,  but will not have access to any of expired of the expired online training  program. </li>
		<li>Upon expiry of membership, you  will be able to access the workspace with limited functionalities. </li>
		<li>Valid membership is a MUST if  you wish to sit for the CIFA Examination at accredited exam centers. </li>
		<li>Your examination token is valid  for 18 months from the point of enrolment. Therefore, the   exam token will remain valid in your account  for 6 months after your membership expires. </li>
		<li>After 18 months, the exam token  will expire and no refund will be given for unused exam tokens. </li><br/>
	</ol>
	
	<li><strong>E-Learning Users are Not  Allowed to Share Account Access:</strong></li><br/>
		<ol id="myList">
		  <li>Under no circumstances is it  permissible for two or more people to share the access to the SHAPE<sup>TM</sup>  online training program. An e-Learning access is similar to a software license,  in that the permission to use the service lies solely with one person. </li>
		  <li>Online training program  subscriptions are not transferable, and cannot be shared or resold. If account  activity indicates multiple users on one account, the account will be  terminated immediately and no refund will be given.</li>
		</ol><br/>
		
	<li><strong>E-Learning Users are NOT  Allowed to teach using ANY of SHAPE<sup>TM</sup> Online Training Program:</strong></li><br/>
		<p>You are not allowed to teach or  instruct using SHAPE<sup>TM</sup> e-Learning as instructional tools for ANY  REASON without the written permission from SHAPETM. Doing this is  equivalent to sharing account access, and as stated above this is strictly  prohibited.<strong></strong></p>  
	
	<li><strong>You are Responsible for  Verifying System Requirements:</strong></li><br/>
		<p>It is your responsibility to make  sure these e-learning courses are compatible with your system. <strong></strong><br />
		We encourage user to try the online  demo available at <a href="http://www.CIFAOnline.com/demo">www.CIFAOnline.com/demo</a> prior to purchasing of SHAPE<sup>TM</sup> e-learning training programs to  ensure compatibility of SHAPE<sup>TM</sup> e-Learning applications to your  computer system. </p>
		<p>If your system presents the graphics, audio  and video in this sample correctly, you should have no problem using any of SHAPE<sup>TM</sup>  e-Learning based materials. If you are unsure whether or not your computer is  compatible with SHAPE<sup>TM</sup> e-Learning applications, refer to the System  Requirements below. <br />
		Please <strong><u>Click Here</u></strong> to Review System  Requirements for RMC's courses. </p>  
	
	<li><strong>There are No Refunds  Available for SHAPE<sup>TM</sup> online training program:</strong></li><br/>
		No refund is allowed for all or any of the following (Please refer to the respective ruling on the access and usage validation as stated above):   
		<ol id="myList">
		<li>Expired membership, online  training program, CIFA exam token. </li>
		<li>Unused membership, online  training program and exam token that fulfilled the validation period. </li>
		</ol><br/>  
	<li><strong>Refunds are ONLY allowed  under the following circumstances  :</strong></li><br/>
		<ol id="myList">
		<li>Double payment for the same  training program. Claim MUST be done within 7 Days of purchase. After which,  until the 30th Day, SHAPE<sup>TM</sup> will deduct 10% of total  refund amount to cover the administrative charges. </li>
		<li>Cancellation of training  program MUST be done within 24 hours of purchase. This is ONLY allowed for  unused training programs only. For cancellation, the enrolment fees will be  forfeited and SHAPE<sup>TM</sup> will deduct 5% of total refund amount to cover  the administrative charges. </li>
		</ol>  <br/>
	<li><strong>Processing of refund: </strong> </li><br/>
		<ol id="myList">
		<li>Please submit the refund request  with supporting documents to <a href="mailto:info@CIFAOnline.com">info@CIFAOnline.com</a>.  Please include your Candidate ID and sufficient information in the email for us  to make the refund. Incomplete information will only delay the refund process. </li>
		<li>Processing of refund may take 4  to 8 weeks depending on the mode of refund - Credit card, Paypal or Wire  transfer.  </li>
		<li>Refund will be made respective  to the mode of payment used by user to purchase the online training program. SHAPE<sup>TM</sup>  will not be responsible for losses or differences in the foreign exchange  rates. </li>
		<li>User will be  liable for the additional charges incurred in the process of refund by the  various payment platform used (if any), such as Credit Card and Wire Transfer.</li>
		</ol>
</ol>
<br/>
</td></tr></table>
<table style="width:93%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;">
<tr valign="top"><td><input type="checkbox" name="pengakuan1" id="pengakuan1" /></td><td>
I have read and understood the terms and policies pertaining to the SHAPE<sup>TM</sup> Online Training Program. I here by agree to adhere to these terms and policy. 
</td></tr>
</table><br/>
<table style="width:10%; margin:0 auto;">
<tr valign="top"><td><input type="button" name="proceddnext" value=" Next >> " onclick="checkfield()"/></td></tr>
</table>
</td></tr></table>
</form>
