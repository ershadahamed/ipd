<?php
	require_once('../config.php');
	require_once($CFG->dirroot .'/course/lib.php');
	require_once($CFG->libdir .'/filelib.php');
	include('../manualdbconfig.php');

	if($_POST['checktoken'] != ""){
		$checkBox = $_POST['checktoken'];
		
		for($i=0; $i<sizeof($checkBox); $i++){
			//echo $checkBox[$i];
			$querytoken  = $DB->get_records('user_accesstoken',array('userid'=>$checkBox[$i]));
			foreach($querytoken as $qtoken){}
			$examid=$qtoken->courseid.'<br/>';

			$filename="tokendownload";
			$csv_filename = clean_filename($filename.'-'.date('Ymd').'-'.time('now').'.csv');

			header("Content-Type: application/vnd.ms-excel");

			//$sql = "Select * From mdl_cifauser a Inner Join mdl_cifauser_accesstoken b On a.id = b.userid Where b.courseid='".$examid."' AND a.id='".$checkBox[$i]."'";
					
			$statement="
			  mdl_cifacourse a Inner Join
			  mdl_cifaenrol b On a.id = b.courseid Inner Join
			  mdl_cifauser_enrolments c On b.id = c.enrolid Inner Join
			  mdl_cifauser d On c.userid = d.id Inner Join
			  mdl_cifauser_accesstoken e On b.courseid = e.courseid And e.userid = d.id	
			";
			
			$statement.=" WHERE a.category = '3' AND d.usertype='Active Candidate' And d.id='".$checkBox[$i]."' AND a.id='".$examid."'";
			$sql="SELECT *, c.timestart as enroltime, a.id as examid FROM {$statement} ORDER BY d.traineeid ASC";			
			
			$result=mysql_query($sql);
			if(mysql_num_rows($result)!='0'){			
				if($i < '1'){
					$fileContent="Username;Firstname;Lastname;Email;Traineeid;Country;City;Courseid;Accesstoken\n";
				}
				else{ $fileContent=""; }				
					$data=mysql_fetch_array($result);
					if($i < '0'){
						$fileContent.= "".$data['traineeid'].";".$data['firstname'].";".$data['lastname'].";".$data['email']."; ".$data['traineeid'].";".$data['country'].";".$data['city'].";".$data['courseid'].";".trim($data['user_accesstoken'])."";
					}else{
						$fileContent.= "\n".$data['traineeid'].";".$data['firstname'].";".$data['lastname'].";".$data['email']."; ".$data['traineeid'].";".$data['country'].";".$data['city'].";".$data['courseid'].";".trim($data['user_accesstoken'])."";
					}
					$fileContent=str_replace("\n\n","\n",$fileContent);
					echo $fileContent;
			}
			header("content-disposition: attachment;filename=$csv_filename");
		}		
	} /* else{
		$linkto=$CFG->wwwroot. '/offlineexam/multi_token_download.php';
		header('Location: '.$linkto);
	}  */
	
	//for single download
	if($_POST['checktoken'] == ""){
	if(($_GET['examid']!='')){
		$userid=$_GET['id'];
		$courseid=$_GET['examid'];
		
		//update token, center ID, token start date, token expiry
		$access_token=uniqid(rand());
		$tokencreated=strtotime('now');
		$tokenexpiry=strtotime(date('d-m-Y H:i:s',$tokencreated) . " + 1 year");
		
		$sqlUP=mysql_query("UPDATE {$CFG->prefix}user_accesstoken SET centerid='".$USER->id."', user_accesstoken='".$access_token."',
			timecreated_token='".$tokencreated."', tokenexpiry='".$tokenexpiry."'
			WHERE userid='".$userid."' AND courseid='".$courseid."'") 
		or die("Not update".mysql_error());	
		//End update
		
		//download side
		$filename="tokendownload";
		$csv_filename = clean_filename($filename.'-'.date('Ymd').'-'.time('now').'.csv');

		header("Content-Type: application/vnd.ms-excel");
		
		$sql = "Select * From mdl_cifauser a Inner Join mdl_cifauser_accesstoken b On a.id = b.userid Where b.courseid='".$_GET['examid']."' AND a.id='".$userid."'";
		$result=mysql_query($sql);
		if(mysql_num_rows($result)>0){
			$fileContent="Username;Firstname;Lastname;Email;Traineeid;Country;City;Courseid;Accesstoken\n";				
			while($data=mysql_fetch_array($result))
			{
				$fileContent.= "".$data['traineeid'].";".$data['firstname'].";".$data['lastname'].";".$data['email']."; ".$data['traineeid'].";".$data['country'].";".$data['city'].";".$data['courseid'].";".trim($data['user_accesstoken'])."";
			}
			$fileContent=str_replace("\n\n","\n",$fileContent);
			echo $fileContent;
		}
		header("content-disposition: attachment;filename=$csv_filename");	
	}}
?> 