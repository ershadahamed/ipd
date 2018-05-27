<?php
require_once('../config.php');
include_once('../manualdbconfig.php'); 
if($_POST['downloadall'] != ""){
if(isset($_POST['dtoken'])){
	
	$checkBox=$_POST['downloadall'];
	for($i=0; $i<sizeof($checkBox); $i++){
		$down=$checkBox[$i];
		//select user from DB
		$querytoken  = $DB->get_records('user',array('id'=>$down));
		foreach($querytoken as $qtoken){}			

		$sqlvisupdate=mysql_query("UPDATE {$CFG->prefix}user_accesstoken b SET b.status='1' 
			WHERE b.userid='".$qtoken->id."'") or die("Not update".mysql_error());
		
		$filename="batch_trainee";
		$csv_filename = clean_filename($filename.'-'.date('Ymd').'-'.time('now').'.csv');

		header("Content-Type: application/vnd.ms-excel");
		header("Content-description: File Transfer");
		header("content-disposition: attachment;filename=$csv_filename"); 
		header("Pragma: public");
		header("Cache-control: max-age=0");
		header("Expires: 0");			
		
		$sql = "SELECT * FROM mdl_cifauser_accesstoken a, mdl_cifauser b WHERE a.userid = b.id AND a.userid='".$down."'";	
		$result=mysql_query($sql);
		if(mysql_num_rows($result)>0){
			if($i < '1'){
			$fileContent="Username;Firstname;Lastname;Email;Traineeid;Country;City;Courseid;Accesstoken";
			}
			else{ $fileContent=""; }
			//while($data=mysql_fetch_array($result))
			$data=mysql_fetch_array($result);
			{
				if($i < '0'){
				$fileContent.= "".$data['traineeid'].";".$data['firstname'].";".$data['lastname'].";".$data['email']."; ".$data['traineeid'].";".$data['country'].";".$data['city'].";".$data['courseid'].";".$data['user_accesstoken']."";
				}else{
				$fileContent.= "\n".$data['traineeid'].";".$data['firstname'].";".$data['lastname'].";".$data['email']."; ".$data['traineeid'].";".$data['country'].";".$data['city'].";".$data['courseid'].";".$data['user_accesstoken']."";
				}
			}

			$fileContent=str_replace("\n\n","\n",$fileContent);
			echo $fileContent;
		}			
	}	
	}
}else{
?><script type="text/javascript">location.href = '/shape/hradmin/traineeregistration.php';</script><?php
}
?>	