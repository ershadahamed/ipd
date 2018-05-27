var xmlHttp


function run_query() {
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
alert ("This browser does not support HTTP Request");
return;
} // end if
var url = "search.php?search=" + searchvalue;
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
} //end function

function stateChanged(){
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
document.getElementById("searchContainer").innerHTML=xmlHttp.responseText;
} //end if
} //end function

function GetXmlHttpObject() {
var xmlHttp=null;
try {
// For these browsers: Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}catch (e){
//For Internet Explorer
try{
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
}
}
return xmlHttp;
} //end function