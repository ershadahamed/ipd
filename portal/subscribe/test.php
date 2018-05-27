<html>
<head>
    <title>cifa</title>
    <style type="text/css" media="all">
    
    body {
        font: 0.8em arial, helvetica, sans-serif;
    }
	   
    #header ul {
        /*list-style: none;*/
        padding: 0;
        margin: 0;
		list-style-type: none;
    }
    
    #header li {
		list-style-type: none;
        float: left;
        border: 1px solid #bbb;
        border-bottom-width: 0;
        margin: 0;
    }
    
    #header a {
        text-decoration: none;
        display: block;
        background: #eee;
        padding: 0.24em 1em;
        color: #00c;
        width: 8em;
        text-align: center;
    }
    
    #header a:hover {
        background: #ddf;
    }
    
    #header #selected {
        border-color: #cccccc;
    }
    
    #header #selected a {
        position: relative;
        top: 1px;
        background: white;
        color: black;
        font-weight: bold;
    }
    
    #content {
        border: 1px solid #cccccc;
        clear: both;
        padding: 0 1em;
		background-color:#FFFFCC;
    }
    
    h1 {
        margin: 0;
        padding: 0 0 1em 0;
    }
	
	#content.col1{ width:100%; float:left; font-weight:bold; }
	#content.col2{ float:left; font-weight:bold; text-align:center; }
	#content.col3{ float:left; }
	
	
    </style>
</head>
<body>
<br/>
<div id="header">
<ul>
    <li><a href="fullpackage.php?fullpackage-module">Full Package</a></li>
    <li><a href="coursecountent.php?course-content">Course Content</a></li>
    <li id="selected"><a href="moduletest.php?module-test">Module Test</a></li>
</ul>
</div>

<div id="content" style="margin-left: auto; margin-right: auto;">
<br/>
<?php
	$coursename=$_POST['coursename'];
	$duration=$_POST['duration'];
	$summary=$_POST['summary'];
	$level=$_POST['level'];
	$price=$_POST['price'];
?>
<form action="modulesuccess_main.php" method="post">
<p><b>Details About Module Test</b></p>
	<p>
	<table>
		<tr>
			<td width="30%">Course Name</td>
			<td width="1%">:</td>
			<td><?php echo $coursename; ?><input type="hidden" name="modulename" value="<?php echo $coursename; ?>" /></td>
		</tr>	
		<tr>
			<td>Duration</td><td>:</td><td><?php echo $duration; ?><input type="hidden" name="attempts" value="<?php echo $duration; ?>" /></td>
		</tr>
		<tr>
			<td>Summary</td>
			<td>:</td>
			<td>
			<?php echo $summary; ?><input type="hidden" name="summary" value="<?php echo $summary; ?>" />
			</td>
		</tr>
		<tr>
			<td>Level</td><td>:</td><td><?php echo $level; ?><input type="hidden" name="level" value="<?php echo $level; ?>" /></td>
		</tr>
		<tr>
			<td>Price</td><td>:</td><td><?php echo $price; ?><input type="hidden" name="price" value="<?php echo $price; ?>" /></td>
		</tr>
	</table>
	</p>


<p><b>Trainee Details</b></p>
<p>
<table>
<tr><td width="30%">Trainee ID	</td><td width="1%">:</td><td><input type="text" name="traineeid" /></td></tr>
<tr><td>Trainee Name			</td><td width="1%">:</td><td><input type="text" name="name" size="40" /></td></tr>
<tr><td>Address					</td><td width="1%">:</td><td><input type="text" name="trainee_address" size="40"/></td></tr>
<tr><td>Email					</td><td width="1%">:</td><td><input type="text" name="email" /></td></tr>
<tr><td>Phone Num.				</td><td width="1%">:</td><td><input type="text" name="phone_no" /></td></tr>
</table>
</p>
<p align="center"><input type="submit" name="submit" value="Proceed" /></p>
</form>
  <br/>
</div>
</body></html>