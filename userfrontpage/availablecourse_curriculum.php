<form name="searchform" method="post">
<table>	
<tr>
    <td width="70%" valign="center" >&nbsp; </td>
    <td width="30%" align="right" valign="center">
        <table width="100%" border="0" width="100%" style="display:none;padding:0; margin:0;"><tr><td align="right" width="95%">
        <input type="text" name="search" size="50" style="height:18px;">
        </td>
        <td align="right" width="5%">    
            <a href="javascript:document.searchform.submit()" onmouseover="document.searchform.sub_but.src='image/search.png'" 
            onmouseout="document.searchform.sub_but.src='image/search.png'"  onclick="return val_form_this_page()">
            <img src="image/search.png" width="25" border="0" alt="Submit this form" name="sub_but" />
            </a>               
        </td></tr></table>
    </td>
</tr>
</table>
</form>  

<table id="avalaiblecourse" border="0" cellpadding="0" cellspacing="0">
<?php	
    $search=$_POST['search'];
    $sqlCourses="Select *
    From
        mdl_cifacourse_categories  a
    Where
        a.parent='7'";				  
    //if($search!=''){$sqlCourses.=" And (a.fullname LIKE '%".$search."%' Or a.shortname LIKE '%".$search."%')";} 
   // $sqlCourses.=" Order By a.id Desc";
	
	
	
    $queryCourses=mysql_query($sqlCourses);
    $count=mysql_num_rows($queryCourses);
    if($count>0){
    while($rowCourses=mysql_fetch_array($queryCourses)){ 
?>	
<tr><td>
    <h4 class="name">
    <?php 
        if (isloggedin()) { 
            //not administrator
            if(($USER->id)!='2'){
                //if user not purchase yet
                ///if($rowC == '0'){
					$sqlse=mysql_query("SELECT * FROM mdl_cifa_modulesubscribe WHERE traineeid='".$USER->traineeid."' AND (payment_status='Pending' OR payment_status='New') AND courseid='".$rowCourses['courseid']."'");
					$sqlcount=mysql_num_rows($sqlse);
					if($sqlcount!='0'){ //if=1
					$sqlze=mysql_fetch_array($sqlse);
					if($sqlze['payment_status']=='Pending'){?>
						<a href="#" onClick='alert("You already subscribe this course using payment option <?=ucwords(strtoupper($sqlze['paymethod']));?> and status still <?=ucwords(strtoupper($sqlze['payment_status']));?>.\nPlease proceed your payment.")'>
						<?php echo $rowCourses['name'];?></a>
					<?php }else{ ?>
                    <a href="portal/subscribe/confirmation_stuck.php?id=<?=$rowCourses['id'];?>" title="click to subscribe <?php echo $rowCourses['name'];?>">
                    <?php echo $rowCourses['name'];?></a> 
					<?php }}else{ ?>				
                    <a href="portal/subscribe/paydetails_loggeduser.php?id=<?=$rowCourses['id'];?>" title="click to subscribe <?php echo $rowCourses['name'];?>">
                    <?php echo $rowCourses['name'];?></a> 

                <?php 
                }//}
                //if administrator
                }else{ ?>
                    <a href="course/view.php?id=<?=$rowCourses['id'];?>" title="click to enter this <?php echo $rowCourses['name'];?>">
                    <?php echo $rowCourses['name'];?></a>		

    <?php	}
        //if not login
        }else{ 
    ?>
            <a href="portal/subscribe/paydetails.php?id=<?=$rowCourses['id'];?>" title="click to subscribe <?php echo $rowCourses['name'];?>">
            <?php echo $rowCourses['name'];?></a>
    <?php } ?>
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
						<a href="#" onClick='alert("You already subscribe this course using payment option <?=ucwords(strtoupper($sqlze['paymethod']));?> and status still <?=ucwords(strtoupper($sqlze['payment_status']));?>.\nPlease proceed your payment immediately.")'>
						<img src="image/shopcartapply.png" width="30" title="Purchase a <?php echo $rowCourses['name'];?>"/></a>	
					<?php }else{ ?>
					<a href="portal/subscribe/confirmation_stuck.php?id=<?=$rowCourses['id'];?>">
					<img src="image/shopcartapply.png" width="30" title="Purchase a <?php echo $rowCourses['name'];?>"/></a>					
				<?php
				}}else{
				?>
					<a href="portal/subscribe/paydetails_loggeduser.php?id=<?=$rowCourses['id'];?>">
					<img src="image/shopcartapply.png" width="30" title="Purchase a <?php echo $rowCourses['name'];?>"/></a>
				<?php } ?>
				</td> 
		<?php }} ?>
</tr>

<?php if($rowCourses['description'] != ''){ ?>

<tr><td style="padding-top:0px; padding-bottom:0px;">    
<?php 
        echo '<div style="text-align:justify; padding-bottom:10px;">'.$rowCourses['description'].'</div>';
?>
</td></tr>
<?php }else{ ?>
<tr><td style="padding-top:0px; padding-bottom:0px;"><?php echo "<div style='padding-bottom:10px;'>No summary.</div>";?></td></tr>
<?php 
    }

//not found search records.
}
}else{ echo "No records found.";} ?>	</table>	