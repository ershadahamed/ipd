<script type="text/javascript">
  function tabs2(x)
  {
    var lis=document.getElementById("sidebarTabs").childNodes; //gets all the LI from the UL
 
    for(i=0;i<lis.length;i++)
    {
      lis[i].className=""; //removes the classname from all the LI
    }
    x.className="selected"; //the clicked tab gets the classname selected
    var res=document.getElementById("tabContent");  //the resource for the main tabContent
    var tab2=x.id;
    switch(tab2) //this switch case replaces the tabContent
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
<table><tr><td>
<div class="tabContainer" >
  <ul class="digiTabs" id="sidebarTabs">
    <li id="tab1" class="selected"  onclick="tabs2(this);" title="List of users">Courses</li>
  </ul>
  <div id="tabContent">
		<?php include('admin-courses.php'); ?>
  </div>
</div>
 
<div id="tab1Content" style="display:none;">
	<?php include('admin-courses.php'); ?>
</div>
</td></tr></table>