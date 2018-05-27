<?php if (isloggedin()) { 
	if(($USER->id)=='2'){?>
            <fieldset><legend>List of available courses</legend>
<?php   }}else{ ?> <!--fieldset><legend>List of available courses</legend--><?php } ?>
<fieldset id="fieldset">
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
    $sqlCourses="Select *, b.id as enrolid
    From
        mdl_cifacourse a,
        mdl_cifaenrol b
    Where
        a.id = b.courseid And
        (a.category = '1' And
        b.enrol = 'paypal' And
        a.visible = '1' And
        b.status = '0')";				  
    if($search!=''){$sqlCourses.=" And (a.fullname LIKE '%".$search."%' Or a.shortname LIKE '%".$search."%')";} 
    $sqlCourses.=" Order By a.id Desc";
    $queryCourses=mysql_query($sqlCourses);
    $count=mysql_num_rows($queryCourses);
    if($count>0){
      
    while($rowCourses=mysql_fetch_array($queryCourses)){
    //if($rowCourses['courseid']!='28'){ //chatt course
	$sqlC=mysql_query("SELECT * FROM mdl_cifauser_enrolments WHERE userid='".$USER->id."' AND enrolid='".$rowCourses['enrolid']."'");
	$rowC=mysql_num_rows($sqlC);  
?>	
<?php if($rowC == '0'){ ?>
<tr><td>
    <h4 class="name">
<?php } ?>
    <?php 
        if (isloggedin()) { 
            //not administrator
            if(($USER->id)!='2'){
                //if user not purchase yet
                if($rowC == '0'){
					$sqlse=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE traineeid='".$USER->traineeid."' AND (payment_status='Pending' OR payment_status='New') AND courseid='".$rowCourses['courseid']."'");
					$sqlcount=mysql_num_rows($sqlse);
					if($sqlcount!='0'){ //if=1
					$sqlze=mysql_fetch_array($sqlse);
					if($sqlze['payment_status']=='Pending'){?>
						<a href="#" onClick='alert("You already subscribe this course using payment option <?=ucwords(strtoupper($sqlze['paymethod']));?> and status still <?=ucwords(strtoupper($sqlze['payment_status']));?>.\nPlease proceed your payment.")'>
						<?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a>
					<?php }else{ ?>
                    <a href="portal/subscribe/confirmation_stuck.php?id=<?=$rowCourses['courseid'];?>" title="click to subscribe modules">
                    <?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a> 
					<?php }}else{ ?>				
                    <a href="portal/subscribe/paydetails_loggeduser.php?id=<?=$rowCourses['courseid'];?>" title="click to subscribe modules">
                    <?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a> 

                <?php 
                }}
                //if administrator
                }else{ ?>
                    <a href="course/view.php?id=<?=$rowCourses['courseid'];?>" title="click to enter this course">
                    <?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a>		

    <?php	}
        //if not login
        }else{ 
    ?>
            <a href="portal/subscribe/paydetails.php?id=<?=$rowCourses['courseid'];?>" title="click to subscribe modules">
            <?php echo $rowCourses['fullname'];?> - <?php echo $rowCourses['shortname'];?></a>
    <?php } ?>
    <?php if($rowC == '0'){  ?>  
    </h4>
</td>
	<?php 
        if (isloggedin()) { 
            //not administrator
            if(($USER->id)!='2'){	
	?>
				<td rowspan="2">
				<?php
				$sqlse=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE traineeid='".$USER->traineeid."' AND (payment_status='Pending' OR payment_status='New') AND courseid='".$rowCourses['courseid']."'");
				$sqlcount=mysql_num_rows($sqlse);				
				if($sqlcount!='0'){
					$sqlze=mysql_fetch_array($sqlse);
					if($sqlze['payment_status']=='Pending'){?>
						<a href="#" onClick='alert("You already subscribe this course using payment option <?=ucwords(strtoupper($sqlze['paymethod']));?> and status still <?=ucwords(strtoupper($sqlze['payment_status']));?>.\nPlease proceed your payment.")'>
						<img src="image/shopcartapply.png" width="30" title="Purchase a <?php echo $rowCourses['fullname'];?>"/></a>	
					<?php }else{ ?>
					<a href="portal/subscribe/confirmation_stuck.php?id=<?=$rowCourses['courseid'];?>">
					<img src="image/shopcartapply.png" width="30" title="Purchase a <?php echo $rowCourses['fullname'];?>"/></a>					
				<?php
				}}else{
				?>
					<a href="portal/subscribe/paydetails_loggeduser.php?id=<?=$rowCourses['courseid'];?>">
					<img src="image/shopcartapply.png" width="30" title="Purchase a <?php echo $rowCourses['fullname'];?>"/></a>
				<?php } ?>
				</td> 
		<?php }} ?>
</tr> <?php } ?>

<?php if($rowCourses['summary'] != ''){ ?>
<?php if($rowC == '0'){  ?> 
<tr><td style="padding-top:0px; padding-bottom:0px;">
<?php } ?>         
<?php 
    if (isloggedin()) { 
        if(($USER->id)!='2'){
            //if user not purchase yet
            if($rowC == '0'){
            echo '<div style="text-align:justify; padding-bottom:10px;">'.$rowCourses['summary'].'</div>';
            }
        }else{
            echo '<div style="text-align:justify; padding-bottom:10px;">'.$rowCourses['summary'].'</div>';
        }
    }else{
        echo '<div style="text-align:justify; padding-bottom:10px;">'.$rowCourses['summary'].'</div>';
    }
?>
<?php if($rowC == '0'){  ?> 
</td></tr>
<?php } ?> 
<?php }else{ ?>
<?php if($rowC == '0'){  ?> 
<tr><td style="padding-top:0px; padding-bottom:0px;">
<?php }  ?> 
<?php 
    //if user not purchase yet
    if($rowC == '0'){
        echo "<div style='padding-bottom:10px;'>No summary.</div>";
    }
    }
?>
<?php if($rowC == '0'){  ?>         
</td></tr>
<?php }  ?> 
<?php //}//if not chat

//not found search records.
}
}else{ echo "No records found.";} ?>	</table>	
</fieldset><?php if(($USER->id)=='2'){?></fieldset><?php } ?>