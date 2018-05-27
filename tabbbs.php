<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Using Tabs With PHP</title>
<style>
.link{
  font-family:tahoma;
  font-size:11px;
  font-weight:bold;

  color:white;
  text-decoration:none;
}
</style>
</head>
 
<body>
<?
  $id=$_REQUEST['id'];
 
  $links=array();

 
  $links[]="Home";
  $links[]="Services";
  $links[]="Products";

  $links[]="Downloads";
  $links[]="Contact Us";
 
  $total_links=count($links);

?>
  <table cellpadding="0px" cellspacing="0">

    <tr>
      <td width="30px">&nbsp;</td>
<?
	for($i=0;$i<$total_links;$i++){ 
	  if($i+1==$id){
?>
      <td style="padding-left:3px">

  <table cellpadding="0" cellspacing="0">
    <tr height="28px">

      <td width="15px"><img src="images/selected-left.gif" /></td>
      <td style="background-image:url(images/selected.gif);" class="link"><?=$links[$i]?></td>

      <td width="15px"><img src="images/selected-right.gif" /></td>
    </tr>

  </table>
      </td>
      <? } else { ?>
      <td style="padding-left:3px">
  <table cellpadding="0" cellspacing="0">

    <tr height="28px">
      <td width="13px"><img src="images/tab-left.gif" /></td>

      <td style="background-image:url(images/tab.gif);"><a href="?id=<?=$i+1?>" class="link"><?=$links[$i]?></a></td>

      <td width="13px"><img src="images/tab-right.gif" /></td>
    </tr>

  </table>
      </td>
      <? } // else end
 
      }  //for end
    ?>
      <td width="30px">&nbsp;</td>
    </tr>

    <tr>
      <td colspan="<?=$total_links+2?>" bgcolor="#1895D5">&nbsp;</td>
    </tr>

    <tr>
      <td colspan="<?=$total_links+2?>" style="border:1px #1895D5 solid;">
        <h1 style="color:#1895D5">The text for linkid<?=$id?> goes here ...</h1>

      </td>
    </tr>
  </table>
</body>
</html>