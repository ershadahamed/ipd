<form name="searchform" method="post">
<table>	
<tr>
    <td width="70%" valign="center" >&nbsp; </td>
    <td width="30%" align="right" valign="center">
        <table width="100%" border="0" width="100%" style="padding:0; margin:0;"><tr><td align="right" width="95%">
        <input type="text" name="search" size="50" style="height:18px;">
        </td>
        <td align="right" width="5%">    
            <a href="javascript:document.searchform.submit()" onmouseover="document.searchform.sub_but.src='image/search.png'" 
            onmouseout="document.searchform.sub_but.src='image/search.png'"  onclick="return val_form_this_page()">
            <img src="image/search.png" width="25" border="0" alt="Submit this form" name="sub_but" />
            </a>               
        <!--button><img src="image/search.png" width="18px"></button-->
        </td></tr></table>
    </td>
</tr>
</table>
</form>
<table id="avalaiblecourse" border="0" cellpadding="0" cellspacing="0">
<?php
$search=$_POST['search'];
$sqlSelect2=mysql_query(
"Select
    a.category,
    a.fullname
From
    mdl_cifacourse a,
    mdl_cifaenrol b,
    mdl_cifauser_enrolments c
Where
    a.id = b.courseid And
    b.id = c.enrolid And
    (c.userid = '".$USER->id."' And c.status!='1' And 
    a.category='1' And a.id != '28' And a.visible='1') 
Order by 
    a.id desc");
            
$rowOrder2=mysql_num_rows($sqlSelect2);
if(($rowOrder2>='1')){            	
//*****************available courses for trainee******************************//				
$sqlCourses="Select
                a.id,
                a.shortname,
                a.fullname,
                a.duration,
                a.startdate,
                b.courseid,
                a.category,
                a.summary
            From
                mdl_cifacourse a,
                mdl_cifaenrol b,
                mdl_cifauser_enrolments c,
                mdl_cifauser d
            Where
                a.id = b.courseid And
                b.id = c.enrolid And
                c.userid = d.id And
                (c.userid = '".$USER->id."' And 
                a.category='1' And a.visible='1')";
    if($search!=''){$sqlCourses.= " And (a.fullname LIKE '%".$search."%' Or a.shortname LIKE '%".$search."%')";}
    $sqlCourses.=" Order by a.id desc";                
    $queryCourses=mysql_query($sqlCourses);
    $rs3=mysql_num_rows($queryCourses);
    if($rs3>0){                

	while($rowCourses=mysql_fetch_array($queryCourses)){
	if($rowCourses['courseid']!='28'){

?>	

<tr><td>
<h4 class="name">
<a href="course/view.php?id=<?=$rowCourses['courseid'];?>" title="click to enter this course">
<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a>
</h4></td></tr>
<?php if($rowCourses['summary'] != ''){ ?>
<tr>
<td style="padding-top:0px; padding-bottom:0px;">
<?php 
	echo $rowCourses['summary'];
?>
</td></tr>
<?php }else{ ?>
<tr>
<td style="padding-top:0px;">    
<?php echo "No summary for this modules";?>
</td></tr>
<?php } ?>
<tr><td style="padding-bottom:0px; padding-top:0px;">
        <b>Announcement:</b>
        <?php 
                $announcement = $rowCourses['courseid'];
                $sql="
                        Select
                            *
                        From
                            mdl_cifaforum_discussions a,
                            mdl_cifaforum_posts b
                        Where
                            a.name = b.subject And
                            a.course = '$announcement'
                ";

                $querySql=mysql_query($sql);
                $annResult=mysql_fetch_array($querySql);

                if($annResult){
                        echo $annResult['message'];
                }else{
                //echo $row['startdate'];
                        echo "<div style='padding-bottom:10px;'>Not available</div>";
                }
        ?>
</td></tr>			
<?php }


}
//not found search records.
}else{ echo 'No records found. Try search again.'; }
//not found records.
}else{ echo '<tr><td>'; echo 'No enrolment records found.'; echo'</td></tr>';} ?>	</table>