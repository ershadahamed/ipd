<?php
	require('../config.php');
?>
<script language="javascript">
function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail ID")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail ID")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

 		 return true					
	}
	function validate(){
		var f=document.form;		
		if((f.candidateid.value=='') && ((f.email.value==null) || (f.email.value=='')) && (f.securityquestion.value=='') && (f.answer.value=='')){
			alert('Enter either candidate ID or email or security question');
			f.candidateid.focus();
			return false;
		}				
		/* if((f.email.value==null) || (f.email.value=='')){
			alert('Email required');
			f.email.focus();
			return false;
		}
		if (echeck(f.email.value)==false){
			f.email.value=""
			f.email.focus()
			return false
		}
		if(f.securityquestion.value==''){
			alert('Security question required');
			f.securityquestion.focus();
			return false;
		}		
		if(f.answer.value==''){
			alert('Answer required');
			f.answer.focus();
			return false;
		} */
		f.submit();
	}
</script>
<form action="" method="post" name="form" id="form" onsubmit="return validate()">
<fieldset style="padding: 0.6em;" id="user" class="clearfix">
<legend style="font-weight:bolder;" class="ftoggler">Password Reset Options</legend>
<table width="100%" style="border:0px solid">
  <tr>
    <td width="20%" align="right"><?=get_string('candidateid');?>&nbsp;</td>
    <td width="26%"><input name="candidateid" type="text" id="candidateid" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" /> </td>
    <td width="54%">OR</td>
  </tr>
  <tr>
    <td align="right"><?=get_string('email');?>&nbsp;</td>
    <td><input name="email" type="text" id="email" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" /> 
    </td>
    <td>OR</td>    
  </tr>
  <tr>
    <td align="right"><?=get_string('squestion');?>&nbsp;</td>
    <td>
    <select name="securityquestion" id="securityquestion">
    <option value=""> Select one security question.. </option>
    <?php
		$question=mysql_query("Select * From {$CFG->prefix}security_question");
		while($sq=mysql_fetch_array($question)){
			echo "<option value='".$sq['id']."'>".$sq['question']."</option>";
		}
	?>
    </select>
    </td>
     <td rowspan="2" valign="top"><p><em>When you created your CIFA workspace, you  created a security question. Answer the question correctly to access your  account</em></p></td>
  </tr>
  <tr>
    <td align="right"><?=get_string('sqyouranswer');?>&nbsp;</td>
    <td><input name="answer" type="text" id="answer" onKeyUp="javascript:this.value=this.value.toTitleCase()" size="40" /></td>
   	</tr>
</table></fieldset>

<table border="0" align="center">
  <tr>
    <td><input type="submit" name="submitbutton" id="submitbutton" value="Submit"></td>
  </tr>
</table></form>
