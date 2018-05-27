<style>
<?php 
	//include('css/style2.css'); 
?>
</style>
<script type="text/javascript">
  function tabs(x)
  {
    var lis=document.getElementById("sidebarTabs").childNodes; //gets all the LI from the UL
 
    for(i=0;i<lis.length;i++)
    {
      lis[i].className=""; //removes the classname from all the LI
    }
    x.className="selected"; //the clicked tab gets the classname selected
    var res=document.getElementById("tabContent");  //the resource for the main tabContent
    var tab=x.id;
    switch(tab) //this switch case replaces the tabContent
    {
      case "tab1":
        res.innerHTML=document.getElementById("tab1Content").innerHTML;
        break;
 
      case "tab2":
        res.innerHTML=document.getElementById("tab2Content").innerHTML;
        break;
		
      /*case "tab3":
        res.innerHTML=document.getElementById("tab3Content").innerHTML;
        break;
 
      case "tab4":
        res.innerHTML=document.getElementById("tab4Content").innerHTML;
        break;
		
      case "tab5":
        res.innerHTML=document.getElementById("tab5Content").innerHTML;
        break;	*/	
		
      default:
        res.innerHTML=document.getElementById("tab1Content").innerHTML;
        break;
 
    }
  }
   
</script>
<div class="tabContainer" >
  <ul class="digiTabs" id="sidebarTabs">
	<!--18-business partners-->

		<li id="tab1" class="selected" onclick="tabs(this);" title="List of available courses">List of Available Modules</li>
		<li id="tab2" onclick="tabs(this);" title="List of available exam">List of Available Exam</li>	
  </ul>
  
  <div id="tabContent">
		<?php include('userfrontpage/availablecourse.php'); ?>
  </div>  
</div>
 
<div id="tab1Content" style="display:none;">
	<?php include('userfrontpage/availablecourse.php'); ?>
</div>
<div id="tab2Content" style="display:none;">
	<?php include('userfrontpage/availableexam.php'); ?>
</div>