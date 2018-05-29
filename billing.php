<?php
    include("manualdbconfig.php");
    include("includes/functions.php");

    require_once('config.php');
    require_once('manualdbconfig.php');
    require_once($CFG->dirroot .'/course/lib.php');

    $site = get_site();

    $purchase='Purchase modules';
    $title="$SITE->shortname: Courses - ".$purchase;
    $PAGE->set_title($title);
    $PAGE->set_heading($site->fullname);
	$PAGE->set_pagelayout('buy_a_cifa');
	
    $buy_cifa='Buy Cifa';
	$buyipd=get_string('buyacifa');
	$selectprogram='Select Program';
	$your_details='Your Details';
	$pay_details='Payment Method';
	$PAGE->navbar->add($buyipd)->add($selectprogram)->add($your_details);	
	
    echo $OUTPUT->header();
	
	// if idle for 15minutes
	include('js/js_idletime.php'); 

    if($_REQUEST['command']=='update'){
        $title=$_REQUEST['title'];
        $name=$_REQUEST['name'];
        $middlename=$_REQUEST['middlename'];
        $lastname=$_REQUEST['lastname'];
        $address=$_REQUEST['address'];
        $address2=$_REQUEST['address2'];
		$address3=$_REQUEST['address3'];
        $email=$_REQUEST['email'];
        $phone=$_REQUEST['phone'];	
        $phone2=$_REQUEST['phone2'];			
        $state=$_REQUEST['state'];
		$city=$_REQUEST['city'];
        $postalcode=$_REQUEST['postalcode'];
        $country=$_REQUEST['country'];	
        $dob=$_REQUEST['dob'];
        $gender=$_REQUEST['gender'];
		
        $cp1='1';
        $cp2=$_REQUEST['column2'];
        $cp3=$_REQUEST['column3'];
    }
    //untuk dapatkan senarai negara
    $pilihnegara=mysql_query("SELECT * FROM mdl_cifacountry_list");
?>
<style>
<?php 
    include('css/style2.css'); 
    //include('css/style.css'); 
?>
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js">
</script>

<script language="javascript">
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
<script type="text/javascript">
String.prototype.toTitleCase = function() {
    return this.replace(/([\w&`'��"�.@:\/\{\(\[<>_]+-? *)/g, function(match, p1, index, title) {
        if (index > 0 && title.charAt(index - 2) !== ":" &&
        	match.search(/^(a(nd?|s|t)?|b(ut|y)|en|for|i[fn]|o[fnr]|t(he|o)|vs?\.?|via)[ \-]/i) > -1)
            return match.toLowerCase();
        if (title.substring(index - 1, index + 1).search(/['"_{(\[]/) > -1)
            return match.charAt(0) + match.charAt(1).toUpperCase() + match.substr(2);
        if (match.substr(1).search(/[A-Z]+|&|[\w]+[._][\w]+/) > -1 || 
        	title.substring(index - 1, index + 1).search(/[\])}]/) > -1)
            return match;
        return match.charAt(0).toUpperCase() + match.substr(1);
    });
};
</script>

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
		var f=document.formcart;
		if(f.name.value==''){
			alert('Your firstname is required');
			f.name.focus();
			return false;
		}
		if(f.lastname.value==''){
			alert('Your lastname is required');
			f.lastname.focus();
			return false;
		}	
//		if(f.dob.value==''){
//			alert('Your date of birth is required');
//			f.dob.focus();
//			return false;
//		}
//		if(f.gender.value==''){
//			alert('Your gender is required');
//			f.gender.focus();
//			return false;
//		}		
		if((f.email.value==null) || (f.email.value=='')){
			alert('Your email is required');
			f.email.focus();
			return false;
		}
		if (echeck(f.email.value)==false){
			f.email.value=""
			f.email.focus()
			return false
		}
//		if(f.address.value==''){
//			alert('First line of address is required');
//			f.address.focus();
//			return false;
//		}			
//		if(f.city.value==''){
//			alert('City is required');
//			f.city.focus();
//			return false;
//		}	
//		if(f.postalcode.value==''){
//			alert('Postal code is required');
//			f.postalcode.focus();
//			return false;
//		}	
		if(f.country.value==''){
			alert('Your country is required');
			f.country.focus();
			return false;
		}	
		if(f.phoneM.value==''){
			alert('Your contact number is required');
			f.phoneM.focus();
			return false;
		}		
 		if(f.column3.checked==false){
			alert('You must agree to the IPD Online Policy to proceed.');
			f.country.focus();
			return false;
		}               
		f.command.value='update';
		f.submit();
	}
</script>
<script language="javascript">
function displ()
{
  if(document.formcart.country.options[0].value == true) {
	return false
  }
  else {
	<?php 
	while($negara=mysql_fetch_array($pilihnegara)){ 
	?>
	if(document.formcart.country.options[document.formcart.country.selectedIndex].value=='<?=$negara['countrycode']?>'){
		document.formcart.countrycode.value='('+'+<?=$negara['iso_countrycode'];?>'+')';
		document.formcart.phone.value=document.formcart.phoneM.value;	
	}
	<?php } ?>
  }
  
  
   if(document.formcart.title.options[0].value == true) {
    return false
  }
  else {
	document.formcart.gender.value=document.formcart.title.options[document.formcart.title.selectedIndex].value;
  }
  return true; 
  
}
</script>
<link rel="stylesheet" type="text/css" media="all" href="offlineexam/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="offlineexam/jquery.1.4.2.js"></script>
<script type="text/javascript" src="offlineexam/jsDatePick.jquery.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%m-%Y"
		});
	};
</script>

<script src="script/jquery-1.9.1.js" type="text/javascript"></script>
<link href="http://fiddle.jshell.net/css/result-light.css" type="text/css" rel="stylesheet">
<script>
//<![CDATA[
$(window).load(function(){
$(document).ready(function() {
$("input[type=checkbox]").change(function()
{
var divId = $(this).attr("id");
if ($(this).is(":checked")) {
$("." + divId).show();
}
else {
$("." + divId).hide();
}
});
$("input[type=radio]").change();
});
$(document).ready(function() {
$("input[type=radio]").change(function()
{
var divId = $(this).attr("id");
$("div.check").hide();
$("." + divId).show();
$("input[type=checkbox]").change();
});
});
});//]]> 
</script>

	<?php
		if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
			remove_product($_REQUEST['pid']);
		}
		else if($_REQUEST['command']=='clear'){
			unset($_SESSION['cart']);
		}
		else if($_REQUEST['command']=='update'){
			$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				$pid=$_SESSION['cart'][$i]['productid'];
				$q=intval($_REQUEST['product'.$pid]);
				if($q>0 && $q<=999){
					$_SESSION['cart'][$i]['qty']=$q;
				}
				else{
					$msg='Some proudcts not updated!, quantity must be a number between 1 and 999';
				}
			}
		}
	?>
	
	<script language="javascript">
		function del(pid){
			if(confirm('Do you really mean to delete this item')){
				document.formcart.pid.value=pid;
				document.formcart.command.value='delete';
				document.formcart.submit();
			}
		}
		function clear_cart(){
			if(confirm('This will empty your shopping cart, continue?')){
				document.formcart.command.value='clear';
				document.formcart.submit();
			}
		}
		function update_cart(){
			document.formcart.command.value='update';
			document.formcart.submit();
		}


	</script>	
<?php 
    $strrequired='<font style="color: red;">*</font>'; 
    $mandatory='<font style="color: red;"> &nbsp; * &nbsp; There are required fields in this form marked.</font>'; 
?>
<style>
#shopcart img{max-width:80%;}
</style>
<table id="shopcart" width="80%" border="0" style="text-align:left;">
        <tr>
        <td><img src="image/step2_your_details.png" width="80%"></td>  
        </tr>
</table>        

<!--- step by step----->	
<table border="0" style="text-align:center; width:100%"><tr><td style="text-align:right"><?=$mandatory;?></td></tr></table>

<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler">Shopping Cart</legend>
<div style="margin:0px auto; width:95%; padding-top:20px;">
<div style="color:#F00"><?php echo $msg?></div>
<table id="availablecourse2" width="100%">
<?php
                if(is_array($_SESSION['cart'])){
        echo '<tr class="yellow" bgcolor="#FFFFFF" style="font-weight:bold">
                                        <th width="1%" align="center">No.</th>
                                        <th width="45%">Course Name</th>
                                        <th width="10%" style="text-align:center;">Price</th>
                                        <th width="10%" style="text-align:center;">Amount</th>
                                </tr>';
                        $max=count($_SESSION['cart']);
                        for($i=0;$i<$max;$i++){
                                $pid=$_SESSION['cart'][$i]['productid'];
                                $q=$_SESSION['cart'][$i]['qty'];
                                $pname=get_product_name($pid);
                                if($q==0) continue;
                ?>
                <tr bgcolor="#FFFFFF">				
					<td class="adjacent" style="text-align:center;"><?php echo $i+1?></td>
					<td class="adjacent" style="text-align:left;"><?php echo $pname?></td>
					<td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)?></td>                 
					<td class="adjacent" style="text-align:center;">$ <?php echo get_price($pid)*$q?></td>
					</tr>
    <?php					
                        }
                        if($max>0){
                ?>
                        <tr style="height:30px;">
                                <td class="adjacent" colspan="2" width="70%">&nbsp;</td>
                                <td class="adjacent" style="text-align:center;"><b>Order Total</b></td>
                                <td class="adjacent" style="text-align:center;"><b>$ <?php echo get_order_total()?></b></td>
                        </tr>
                <?php
                        }else{
                                echo "<tr bgColor='#FFFFFF'><td class='adjacent' colspan='7'>There are no items in your shopping cart!</td>";
                        }
                }
                else{
                        echo "<tr bgColor='#FFFFFF'><td class='adjacent'>There are no items in your shopping cart!</td>";
                }
        ?>
</table>
</div>
</fieldset>	
<!-- End purchasing order -->
<?php
	if($_POST['hantar']!='')
	{
		$candidate_id=$_POST['candidate_id'];
		$qquery=mysql_query("SELECT * FROM mdl_cifauser WHERE traineeid='".$candidate_id."'");
		$rowq = mysql_fetch_array($qquery);
		  $q_firstname=$rowq['firstname'];
		  $q_middlename=$rowq['middlename'];
		  $q_lastname=$rowq['lastname'];
		  $q_gender=$rowq['gender'];
		  $q_dob=$rowq['dob'];
		  $q_email=$rowq['email'];
		  $q_address=$rowq['address'];
		  $q_postalcode=$rowq['postcode'];
		  $q_state=$rowq['state'];
		  $q_country=$rowq['country'];
		  $q_phoneno=$rowq['phone1'];
	}
?>
<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler"><?=get_string('useroption');?></legend>
<div style="padding:20px;">
<input type="radio" name="radio" id="existing" value="existing" onClick="this.form.action='';" /> <?=get_string('existingcandidate');?>&nbsp;
<input type="radio" name="radio" id="new_register" value="new_register" onClick="this.form.action='';" /> <?=get_string('newenrolment');?>&nbsp;
</div>
</fieldset>

<div class="check existing" style="display:none">
<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler"><?=get_string('existingcandidate');?></legend>
<?php include("login/index_form_buy_cifa.html"); ?>
</fieldset></div>

<div class="check existing" style="display:none">
        <table border="0" style="text-align:center; width:100%">
        <tr><td>
			<input type="button" name="backbutton" title="back to select program/course" onClick="history.back();" value=" Back " />
		</td></tr></table>
</div>

<div class="check new_register" style="display:none">
<!-- purchasing information -->
<form name="formcart" method="post" onsubmit="return validate()" onClick="return displ();">
    <input type="hidden" name="command" />
	<input type="hidden" name="pid" />
	<!-- Billing info order -->	
	<fieldset style="padding: 0.6em;" id="user" class="clearfix"><legend style="font-weight:bolder;" class="ftoggler"><?=get_string('candidateinfo');?></legend>
	<div style="padding:20px;">
        <table border="0" cellpadding="2px" width="95%">
            <tr><td width="30%"><?=get_string('title');?></td><td width="1%"><strong>:</strong></td>
                <td>
                    <?php if($candidate_id!='' && $q_gender!=''){ ?>
						<select id="title" name="title"><option <?php if($q_gender=='0'){echo'selected';} ?>>Mr.</option><option >Mrs.</option><option <?php if($q_gender=='1'){echo'selected';} ?>>Miss.</option><option>Ms.</option></select>
						<?php }else { ?>
						<select name="title"><option value="0">Mr.</option><option value="1">Mrs.</option><option value="1">Miss.</option><option value="1">Ms.</option></select>
                    <?php } ?>
                </td>
            </tr>
            <tr><td><?=get_string('firstname');?><?=$strrequired;?></td><td width="1%"><strong>:</strong></td><td>
                    <?php if($candidate_id!='' && $q_firstname!=''){ 
					echo '<input type="text" name="name" size="40" value="'.ucwords(strtolower($q_firstname)).'"/>'; 
					}else { ?>
                    <input type="text" name="name" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" />
                    <?php } ?>
            </td></tr>
			<tr><td><?=get_string('middlename');?></td><td width="1%"><strong>:</strong></td><td>
            <?php if(($candidate_id!='' && $q_middlename!='')){
				echo '<input type="text" name="name" size="40" value="'.ucwords(strtolower($q_firstname)).'"/>';
				}else{
			?>
				<input type="text" name="middlename" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" />
			<?php }	?>
			</td></tr>
            <tr><td><?=get_string('lastname');?><?=$strrequired;?></td><td width="1%"><strong>:</strong></td><td>
                    <?php if($candidate_id!='' && $q_lastname!=''){ echo '<input type="text" name="lastname" size="40" value="'.ucwords(strtolower($q_lastname)).'"/>'; }else { ?>
                    <input type="text" name="lastname" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" />
                    <?php } ?>
            </td></tr>
            <tr><td><?=get_string('dob');?></td><td><strong>:</strong></td><td>
                    <?php 
					if($candidate_id!='' && $q_dob!=''){
						if($q_dob!='0'){
						echo date('d/m/Y', $q_dob); 
						}else{ echo '<input type="text" id="inputField" name="dob" size="40" />'; }						
					}else { ?>
                    <input type="text" id="inputField" name="dob" size="40" />
                    <?php } ?>
            </td></tr>	
            <tr><td><?=get_string('gender');?></td><td><strong>:</strong></td><td>
                    <?php if($candidate_id!='' && $q_gender!=''){ ?>
					<select id="gender" name="gender">
                        <option> - Gender - </option>
                        <option value="1" <?php if($q_gender=='1'){ echo 'selected';} ?>>Female</option>
                        <option value="0" <?php if($q_gender=='0'){ echo 'selected';} ?>>Male</option>
                    </select>
					<?php }else { ?>                  
                    <select id="gender" name="gender">
                        <option> - Gender - </option>
                        <option value="1">Female</option>
                        <option value="0">Male</option>
                    </select>
                    <?php } ?>
            </td></tr>	            
            <tr><td><?=get_string('email');?><?=$strrequired;?></td><td width="1%"><strong>:</strong></td><td>
                    <?php if($candidate_id!='' && $q_email!=''){ 
						echo '<input type="text" name="email" size="40" value="'.$q_email.'"/>';
					}else { ?>
                    <input type="text" name="email" size="40" />
                    <?php } ?>
            </td></tr>			
            <tr><td><?=get_string('address1');?></td><td width="1%"><strong>:</strong></td><td>
                    <?php if($candidate_id!='' && $q_address!=''){ 
						echo '<input type="text" name="address" size="40" value="'.ucwords(strtolower($q_address)).'"/>';
					}else { ?>
                    <input type="text" name="address" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" />
                    <?php } ?>
            </td></tr>		
		
            <tr><td><?=get_string('address2');?></td><td width="1%"><strong>:</strong></td><td>
			<?php if($candidate_id!='' && $q_address2!=''){
				echo '<input type="text" name="address2" size="40" value="'.ucwords(strtolower($q_address2)).'"/>';	
			}else{ ?>
                    <input type="text" name="address2" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" />
			<?php } ?>
            </td></tr>
            <tr><td><?=get_string('address3');?></td><td width="1%"><strong>:</strong></td><td>
			<?php if($candidate_id!='' && $q_address2!=''){
				echo '<input type="text" name="address3" size="40" value="'.ucwords(strtolower($q_address3)).'"/>';	
			}else{ ?>
                    <input type="text" name="address3" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" />
			<?php } ?>
            </td></tr>			
			<tr>
				<td><?=get_string('city');?></td><td width="1%">:</td>
				<td><input type="text" name="city" id="city" onKeyUp="javascript:this.value=this.value.toTitleCase()" /></td>
			</tr> 	
            <tr><td><?=get_string('zip');?></td><td width="1%"><strong>:</strong></td><td>
			<?php if($candidate_id!='' && $q_postalcode!=''){
				echo '<input type="text" name="postalcode" size="40" value="'.ucwords(strtolower($q_postalcode)).'"/>';	
			}else{ ?>			
                    <input type="text" name="postalcode" size="40" />
			<?php } ?>
            </td></tr>				
            <tr><td><?=get_string('state');?></td><td width="1%"><strong>:</strong></td><td>
			<?php if($candidate_id!='' && $q_state!=''){
				echo '<input type="text" name="state_code" size="40" value="'.ucwords(strtolower($q_state)).'"/>';	
			}else{ ?>			
                    <input type="text" name="state_code" size="40" onKeyUp="javascript:this.value=this.value.toTitleCase()" />
			<?php } ?>
            </td></tr>				
            <tr><td><?=get_string('selectacountry');?><?=$strrequired;?></td><td width="1%"><strong>:</strong></td><td>

            <?php
                $statement="SELECT * FROM mdl_cifacountry_list";

                if($candidate_id!='' && $q_country!=''){ 
                        //$statement.=" WHERE countrycode='".$q_country."'";
                        $scountry=mysql_query($statement);
                        //$rowcountry=mysql_fetch_array($scountry);
                        
						//echo $rowcountry['countryname']; 
			?>
                <select id="country" name="country">
                        <?php while($rowcountry=mysql_fetch_array($scountry)){ ?>
                        <option value="<?=$rowcountry['countrycode'];?>" <?php if($q_country==$rowcountry['countrycode']){ echo 'selected';}?>><?=$rowcountry['countryname'];?></option>
                        <?php } ?>
                </select>			
			<?php
                }else{
                $scountry=mysql_query($statement);				
            ?>			
                <select id="country" name="country">
                        <option value=""> - </option>
                        <?php while($rowcountry=mysql_fetch_array($scountry)){ ?>
                        <option value="<?=$rowcountry['countrycode'];?>"><?=$rowcountry['countryname'];?></option>
                        <?php } ?>
                </select>
            <?php } ?>
            </td></tr>	
			
            <tr valign="top"><td><?=get_string('officetel');?><?=$strrequired;?></td><td width="1%"><strong>:</strong></td><td>				
                <?php if($candidate_id!='' && $q_phoneno!=''){ 
				
				$mycountry=mysql_query("SELECT * FROM mdl_cifacountry_list WHERE countrycode='".$q_country."'");
				$codecountry=mysql_fetch_array($mycountry);
				$mycountrycode='(+'.$codecountry['iso_countrycode'].')';
				echo '<input type="text" name="countrycode" id="countrycode" value="'.$mycountrycode.'" size="10" readonly="readonly" style="border:0; width: 50px; text-align:center;font-weight:bold;"/>
                <input type="text" id="phoneM" name="phoneM" size="20" value="'.$q_phoneno.'" />
                <input type="hidden" name="phone" id="phone" value="" />';					
				}else { ?>
				<input type="text" name="countrycode" id="countrycode" readonly="readonly" style="border:0; width: 65px; text-align:center;font-weight:bold;"/>
                <input type="text" id="phoneM" name="phoneM" size="20" />
                <input type="hidden" name="phone" id="phone" value="" />					
                <?php } ?>			
            </td></tr>					
        </table>
	</div></fieldset>
        
        <fieldset style="padding: 0.6em;" id="user" class="clearfix">
		<legend style="font-weight:bolder;" class="ftoggler">Communication Preference</legend>
        <?php 
                $policyname='CIFA';

                $sqlstatement=mysql_query("SELECT * FROM mdl_cifacommunication_rules");	
                //$policyname='SHAPE<sup>TM</sup>';
                $count++;
                $count2++;
                $count3++;
                $strrequired='<font color="red">*</font>';	
        ?>
        <table style="width:100%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;"><tr><td>
        <p>Please read the options in this column carefully. </p>
        <table style="width:95%;margin:0 auto;font: 13px/1.231 arial,helvetica,clean,sans-serif;">
            <?php 
                        $no='1';
                        while($sqlquery=mysql_fetch_array($sqlstatement)){ 
                        $bil=$no++;
                        if($sqlquery['visible_1']!='0'){
                ?>
                <tr valign="top">
                        <td>                      
                            <input type="checkbox" name="column<?=$count++;?>" id="column<?=$count2++;?>" value="1" checked <?php if(($bil == '1')){ echo 'disabled="disabled"';} ?> <?php if($_REQUEST['command']=='update'){ echo 'disabled="disabled"';} ?> />
                            <input type="hidden" name="column1" id="column1" value="1" />
                        </td>
                        <td>
                            <?php $linkpolicy=$CFG->wwwroot.'/shape/SHAPEpolicy.pdf';?>
                            <?php 
                                if($sqlquery['firstreg']!='0'){
                                echo $strrequired;
                                }			
                            ?>							
                            <?=$sqlquery['rules_text'];?>
							<?php
								$a = new stdClass();
								
								$policy=$CFG->wwwroot .'/userpolicy.php';
								$a = "<a href=\"javascript:void(0);\" onclick=\"popupwindow('".$policy."', 'myPop1',820,600);\"><u><b>".get_string('cifaonlinepolicy')."</b></u></a>";
								if($bil=='3'){
									echo get_string('compreference3', '', $a);
								}
							?>
                        </td>
                </tr>	
                <?php }} ?>
        </table></td></tr></table><br/></fieldset>

        <table border="0" style="text-align:center; width:100%">
        <tr><td>
		<input type="button" name="backbutton" title="back to select program/course" onClick="history.back();" value=" Back " />
        <?php 
			if($candidate_id!=''){
				/* echo 'tadaa'; */ ?>
				<input type="submit" name="submit" value="Proceed" title="Click 'Confirm & Proceed'" target="_blank" onclick="this.form.action='<?=$CFG->wwwroot. "/paymentoption.php?"; ?>name=<?=$name;?>&&middlename=<?=$middlename;?>&&lastname=<?=$lastname;?>&&dob=<?=$dob;?>&&gender=<?=$gender;?>&&address=<?=$address;?>&&address2=<?=$address2;?>&&address3=<?=$address3;?>&&city=<?=$city;?>&&title=<?=$title;?>&&email=<?=$email;?>&&phone=<?=$phone;?>&&phone2=<?=$phone2;?>&&state_code=<?=$state;?>&&postalcode=<?=$postalcode;?>&&country=<?=$country;?>&&co1=<?=$cp1;?>&&co2=<?=$cp2;?>&&co3=<?=$cp3;?>'" />  
		<?php	}else{
		?>
		<input type="submit" name="submit" value="Proceed" title="Click 'Confirm & Proceed'" target="_blank" onclick="this.form.action='<?=$CFG->wwwroot. "/paymentoption.php?"; ?>name=<?=$name;?>&&middlename=<?=$middlename;?>&&lastname=<?=$lastname;?>&&dob=<?=$dob;?>&&gender=<?=$gender;?>&&address=<?=$address;?>&&address2=<?=$address2;?>&&address3=<?=$address3;?>&&city=<?=$city;?>&&title=<?=$title;?>&&email=<?=$email;?>&&phone=<?=$phone;?>&&phone2=<?=$phone2;?>&&state_code=<?=$state;?>&&postalcode=<?=$postalcode;?>&&country=<?=$country;?>&&co1=<?=$cp1;?>&&co2=<?=$cp2;?>&&co3=<?=$cp3;?>'" />        
        <?php } ?>
		</td></tr></table>
        
</form></div>     
	<!-- End billing info order -->
<?php echo $OUTPUT->footer();?>