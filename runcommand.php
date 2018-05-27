<?php
	include('config.php');
	include('manualdbconfig.php');

	// $s=mysql_query("SELECT firstaccess,orgtype,id, firstname, lastname, username, traineeid, country FROM mdl_cifauser WHERE deleted!='1' AND (country='AE' OR country='IQ') AND firstaccess='0' AND usertype='Active candidate'");
	$s=mysql_query("SELECT firstaccess,orgtype,id, firstname, lastname, username, traineeid, country FROM mdl_cifauser WHERE deleted!='1' AND (country='AE') AND firstaccess='0' AND usertype='HR Admin'");
	while($se=mysql_fetch_array($s)){
		echo $se['id'].' / '.$se['firstname'].' / '.$se['lastname'].' / '.$se['username'].' / '.$se['traineeid'].' / '.$se['country'];
		echo ' / '.$se['orgtype'];
		echo ' / '.date('dmY',$se['firstaccess']);
		
		if ($se['firstaccess']) {
               echo ' / '.$strlastaccess = format_time(time() - $se['firstaccess']);
            } else {
               echo ' / '.$strlastaccess = get_string('never');
            }
		echo "<br/>";
		$sotype=mysql_query("SELECT * FROM mdl_cifaorganization_type WHERE id='8'"); // abu dhabi
		$stype=mysql_fetch_array($sotype);
		/* if($stype){
			$setup20=mysql_query("UPDATE mdl_cifauser SET 
			address='".$stype['address']."', address2='".$stype['address_line2']."', address3='".$stype['address_line3']."', state='".$stype['state']."',postcode='".$stype['zip']."', 
			city='".$stype['city']."', country='".$stype['country']."', orgtel='".$stype['telephone']."', orgfax='".$stype['faxs']."' WHERE id='".$se['id']."'");	
		} */
	}
		
		/* $setup1=mysql_query("UPDATE mdl_cifauser SET username='A14171AE', traineeid='a14171ae', country='AE' WHERE id='171'");
		$setup2=mysql_query("UPDATE mdl_cifauser SET username='A14170AE', traineeid='a14170ae', country='AE' WHERE id='170'");
		$setup3=mysql_query("UPDATE mdl_cifauser SET username='A14167AE', traineeid='a14167ae', country='AE' WHERE id='167'");
		$setup4=mysql_query("UPDATE mdl_cifauser SET username='A14168AE', traineeid='a14168ae', country='AE' WHERE id='168'");
		$setup5=mysql_query("UPDATE mdl_cifauser SET username='A14165AE', traineeid='a14165ae', country='AE' WHERE id='165'");
		$setup6=mysql_query("UPDATE mdl_cifauser SET username='A14164AE', traineeid='a14164ae', country='AE' WHERE id='164'");
		$setup7=mysql_query("UPDATE mdl_cifauser SET username='A14166AE', traineeid='a14166ae', country='AE' WHERE id='166'");
		$setup8=mysql_query("UPDATE mdl_cifauser SET username='A14169AE', traineeid='a14169ae', country='AE' WHERE id='169'");
		
		$setup9=mysql_query("UPDATE mdl_cifauser SET username='B14179AE', traineeid='b14179ae', country='AE' WHERE id='179'");
		$setup10=mysql_query("UPDATE mdl_cifauser SET username='B14180AE', traineeid='b14180ae', country='AE' WHERE id='180'"); */
		
		/* $setup9=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='179'");
		$setup10=mysql_query("UPDATE mdl_cifauser SET  orgtype='7' WHERE id='180'"); */
		/* 
		$setup1=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='171'");
		$setup2=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='170'");
		$setup3=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='167'");
		$setup4=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='168'");
		$setup5=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='165'");
		$setup6=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='164'");
		$setup7=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='166'");
		$setup8=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='169'");		
		
		$setup9=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='160'");
		$setup10=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='163'");
		$setup11=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='161'");
		$setup12=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='159'");
		$setup13=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='154'");
		$setup14=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='153'");
		$setup15=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='156'");
		$setup16=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='157'");			
		$setup17=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='152'");			
		$setup18=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='158'");			
		$setup19=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='155'");			
		$setup20=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='162'"); */

		/* $setup163=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='163'");
		$setup183=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='183'");
		$setup185=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='185'");
		$setup186=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='186'"); */
		// $setup19=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='187'");
		// $setup20=mysql_query("UPDATE mdl_cifauser SET usertype='HR admin', orgtype='7' WHERE id='148'");			
		// $setup20=mysql_query("UPDATE mdl_cifauser SET firstname='Khurram Zaheer', orgtype='7' WHERE id='184'");			
	
	// $setup20=mysql_query("UPDATE mdl_cifauser SET firstname='Aditya', orgtype='7' WHERE id='189'");	
	
		/* $setup9=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Erbil Branch', designation='Senior Relationship Manager', institution='ADIB Iraq' WHERE id='160'");
		$setup10=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Erbil Branch', designation='Operations Officer', institution='ADIB Iraq' WHERE id='163'");
		$setup11=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Erbil Branch', designation='Financial Controller', institution='ADIB Iraq' WHERE id='161'");
		$setup12=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Erbil Branch', designation='SBOO Erbil', institution='ADIB Iraq' WHERE id='159'");
		$setup13=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Whole Sale Banking, Corporate Clients, North Region', designation='Regional Senior Relationship Manager', institution='ADIB Iraq' WHERE id='154'");
		$setup14=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, O&T, Ops, Payment Services', designation='Senior Operations Officer', institution='ADIB Iraq' WHERE id='153'");
		$setup15=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Erbil Branch', designation='Operations Officer', institution='ADIB Iraq' WHERE id='156'");
		$setup18=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Retail Banking, Sales, Branches', designation='AVP-Head of Sales and Distribution', institution='ADIB Iraq' WHERE id='158'");
		$setup16=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Basra Branch', designation='Assistant Relationship Manager', institution='ADIB Iraq' WHERE id='157'");			
		$setup17=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Baghdad Branch', designation='Customer Service Relationship', institution='ADIB Iraq' WHERE id='152'");					
		$setup19=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Erbil Branch', designation='Customer Retail Officer', institution='ADIB Iraq' WHERE id='155'");			
		$setup20=mysql_query("UPDATE mdl_cifauser SET department='ADIB Iraq, Erbil Branch', designation='Teller', institution='ADIB Iraq' WHERE id='162'");	 */
		
/* 		$setup9=mysql_query("UPDATE mdl_cifauser SET department='Call Center', designation='Quality Coordinator', institution='ADIB HQ' WHERE id='171'");
		$setup10=mysql_query("UPDATE mdl_cifauser SET department='Call Center', designation='Quality Coordinator', institution='ADIB HQ' WHERE id='167'");
		$setup11=mysql_query("UPDATE mdl_cifauser SET department='RB-Strategy Products Management', designation='Customer Service Rep.', institution='ADIB HQ' WHERE id='168'");
		$setup12=mysql_query("UPDATE mdl_cifauser SET department='RB-Call Center', designation='Call Center Agent', institution='ADIB HQ' WHERE id='170'");
		$setup13=mysql_query("UPDATE mdl_cifauser SET department='Risk Management', designation='Personal Assistant', institution='ADIB HQ' WHERE id='165'");
		$setup14=mysql_query("UPDATE mdl_cifauser SET department='Risk Management', designation='Analyst', institution='ADIB HQ' WHERE id='164'");
		$setup15=mysql_query("UPDATE mdl_cifauser SET department='RB-Call Center', designation='Team Leader, Call Center', institution='ADIB HQ' WHERE id='166'");
		$setup18=mysql_query("UPDATE mdl_cifauser SET department='RB-Call Center', designation='Quality Coordinator, Call Center', institution='ADIB HQ' WHERE id='169'");		
		
		$setup19=mysql_query("UPDATE mdl_cifauser SET department='Human Resource', designation='Learning & Development Coordinator', institution='ADIB HQ' WHERE id='179'");		
		$setup20=mysql_query("UPDATE mdl_cifauser SET department='Human Resource', designation='Learning & Development Coordinator', institution='ADIB HQ' WHERE id='180'"); */		
	
		/* $sqldelete=mysql_query("
			DELETE FROM {$CFG->prefix}organization_type
			WHERE id != '7'");	 */
			
		/* $qryOrg="SELECT * FROM {$CFG->prefix}organization_type ORDER BY id ASC";
		$sqlOrg=mysql_query($qryOrg);
		while($sql=mysql_fetch_array($sqlOrg)){

		echo '<br/>'.$sql['id'].' / '.$sql['name'];} */	
		
		//echo $setup20=mysql_query("UPDATE mdl_cifauser SET usertype='HR admin' WHERE id='148'");	
		// echo $setup20=mysql_query("UPDATE mdl_cifauser SET usertype='HR admin' WHERE id='191'");	
		// echo $setup20=mysql_query("UPDATE mdl_cifauser SET access_token='005191' WHERE id='191'");	
		echo $setup20=mysql_query("UPDATE mdl_cifauser SET college_edu='0', email='', yearcomplete_edu='', major_edu='' WHERE id='193'");	
		
		// $setup209=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='189'");
		// $setup205=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='188'");
		// $setup206=mysql_query("UPDATE mdl_cifauser SET orgtype='7' WHERE id='190'");
		// $setup20=mysql_query("UPDATE mdl_cifauser SET department='BWB - HR', designation='Head of Technical Training - Retail UAE' WHERE id='191'"); 
		// $setup20=mysql_query("UPDATE mdl_cifauser SET email='Saima.arfeen@adib.com' WHERE id='191'"); 
		
		// $setup9=mysql_query("UPDATE mdl_cifauser SET institution='B14179AE', traineeid='b14179ae', country='AE' WHERE id='179'");
		// $setup10=mysql_query("UPDATE mdl_cifauser SET institution='B14180AE', traineeid='b14180ae', country='AE' WHERE id='180'");
		
		//$password=md5('Password01$');
		//$setup10=mysql_query("UPDATE mdl_cifauser SET password='".$password."' WHERE id='1'");
		
		
?>