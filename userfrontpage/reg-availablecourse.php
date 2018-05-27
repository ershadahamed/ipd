<style type="text/css">
  .tabContainer{
	margin:0px 0 10px 0;width:98%; padding-left: 10px; padding-top: 10px;	
	width: 90%;
  
  }
  .tabContainer .digiTabs{
		list-style:none;
		display:block;
		overflow:hidden;
		margin:0;
		padding:0px;
		position:relative;
		top:1px;
}
  .tabContainer .digiTabs li{
		float:left;
		list-style:none;
		background-color:#356279;/*#46AAF7*/
		border:1px solid #356279;
		/*padding:5px!important;
		font-family:verdana, Arial;
		*/
		cursor:pointer;
		border-bottom:none;
		margin-right:3px;
		width: 130px;
		
		font-family:Calibri, "Lucida Grande", Tahoma, Arial, Verdana, sans-serif;
		font-size:12px;
		font-weight:bolder;
		color:#fff;
		/*height: 2em;*/
		padding: 8px 20px 6px 20px;
		
		text-align: center;
		/**round***/
		-webkit-border-radius: 10px 10px 0 0;
		-moz-border-radius: 10px 10px 0 0;
		-khtml-border-radius : 10px 10px 0 0;
		border-radius: 10px 10px 0 0;
	}
  .tabContainer .digiTabs .selected{
		/*background-color:#fff;*/
		background-color: #EFF7FB;
		color:#393939;
  }
  #tabContent{
		list-style:none;
		padding:10px;
		background-color: #EFF7FB;
		overflow:hidden;
		float:left;
		margin-bottom:30px;
		border:1px solid #356279;
		/*width:950px;*/
		width:98%;
		/***curve section for mozile, crome**/
		-moz-border-radius-bottomleft: 5px;
		-webkit-border-bottom-left-radius: 5px;
		-khtml-border-radius-bottomleft: 5px;	
		-khtml-border-radius-bottomright: 5px;	
		border-bottom-left-radius: 5px;
		-moz-border-radius-bottomright: 5px;
		-webkit-border-bottom-right-radius: 5px;
		border-bottom-right-radius: 5px;	
  }
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
 
      //case "tab2":
        //res.innerHTML=document.getElementById("tab2Content").innerHTML;
        //break;
      default:
        res.innerHTML=document.getElementById("tab1Content").innerHTML;
        break;
 
    }
  }
   
</script>

<div class="tabContainer" >
  <ul class="digiTabs" id="sidebarTabs">
    <!--li id="tab2" onclick="tabs(this);" title="<?//=ucwords(strtoupper(get_string('cifacurriculum')));?>"><?//=ucwords(strtoupper(get_string('cifacurriculum')));?></li-->
    <li id="tab1" class="selected" onclick="tabs(this);" title="<?=ucwords(strtoupper(get_string('shapeipd'))).' '.get_string('courses');?>"><?=ucwords(strtoupper(get_string('shapeipd'))).' '.get_string('courses');?></li>
  </ul>
  <div id="tabContent">
		<?php include('availablecourse.php'); ?>
  </div>
</div>
 
<div id="tab1Content" style="display:none;">
	<?php include('availablecourse.php'); ?>
</div>