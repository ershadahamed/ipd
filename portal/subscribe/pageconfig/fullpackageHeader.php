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
    <li id="selected"><a href="fullpackage.php?fullpackage-module">Full Package</a></li>
    <!--<li><a href="coursecountent.php?course-content">Course Content</a></li>
    <li><a href="moduletest.php?module-test">Module Test</a></li>-->
</ul>
</div>

<div id="content" style="margin-left: auto; margin-right: auto;">