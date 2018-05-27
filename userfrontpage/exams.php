<?php /*<style>
<?php 
	include('css/style2.css'); 
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
 		
      default:
        res.innerHTML=document.getElementById("tab1Content").innerHTML;
        break;
 
    }
  }
   
</script>
<div class="tabContainer" >
  <ul class="digiTabs" id="sidebarTabs">
		<li id="tab1" class="selected" onclick="tabs(this);" title="List of available courses">List of my exams</li>	
  </ul>
  
  <div id="tabContent">
		<?php include('userfrontpage/content2.php'); ?>
  </div>  
</div>
 
<div id="tab1Content" style="display:none;">
	<?php include('userfrontpage/content2.php'); ?>
</div> */?>

<fieldset><legend>List of my exams</legend>
<?php include('userfrontpage/content2.php'); ?>
</fieldset>