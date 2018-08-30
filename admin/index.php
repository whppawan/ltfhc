<?php
require_once("../include/config.php");
require_once("../include/".PAGE6.".php");
require_once("../class/Action.class");
require_once ("../class/Data.class");

error_reporting(E_ALL ^ E_NOTICE);
session_start();

$login=$_SESSION[APPLICATION_ID.'_login'];
//echo "<pre>";
//print_r($login);
//die;
$login_id=$login['login_id'];

if($login['language']!='')
	$language_code = $login['language'];
else
	$language_code = "en";

$login_name=$login['login_name'];
$login_type=$login['login_type'];
$login_sub_type=$login['login_sub_type'];
$login_session_path=LOGIN_SESSION_PATH."$login_type/";
$login_session_time=LOGIN_SESSION_TIME;

$permissionRole = $login['permission'];
//print_r($permissionRole);
if(!$login_id || $_REQUEST['logout']=="true")
	header("Location: ../".PAGE1.".php?logout=true");

$date=date("Y-m-d");

$page=$_GET['page'] ? $_GET['page'] : "report";
$$page="active";

$parrent_page=$_GET['parrent_page'];
$$parrent_page="active";

$table1 =TBL69;	
$data=new Data();
$data_language=$data->getData($con, "id, $language_code as content", "$table1 a", "", "");
$content_lang = $data_language['detail'];

//print_r($content_lang);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>LTFHC</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
	
	<!-----------------------------------Calendar : Start-------------------------------->
	<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
	<!-----------------------------------Calendar : End-------------------------------->
	<style>
	.body{
	min-height: 100%;
    position: relative;
    top: 0px !important;
	}
		/* Remove the navbar's default margin-bottom and rounded borders */ 
	.navbar {
		margin-bottom: 0;
		border-radius: 0;
    }
    
	.navbar-default {
		background-color: #555;
	}
	
	.navbar-default .navbar-brand {
		color:#FFF;
	}
	.navbar-default .navbar-brand:hover,
	.navbar-default .navbar-brand:focus{
		color:#FFF;
	}
	
	.navbar-default .navbar-nav > li > a {
		color:#FFF;
	}
	
	.navbar-default .navbar-nav > li > a:hover {
		color:#FFF;
	}
	
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
		padding-top: 20px;
		background-color: #f1f1f1;
		height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
		background-color: #555;
		color: white;
		padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
		.sidenav {
			height: auto;
			padding: 15px;
		}
		.row.content {height:auto;} 
    }
	
	/************************Loader : Start************************/
	.loader {
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16 solid blue;
		border-right: 16px solid green;
		border-bottom: 16px solid red;
		border-left: 16px solid pink;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
		
		width: 100px;
		height: 100px;
		position:absolute;
		top:10%;
		left:47%;
	}

	@-webkit-keyframes spin {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
	/************************Loader : End************************/
	</style>
	<link rel="stylesheet" href="../css/select2.css">
	<script>
	
	function getForm(strURL, width)
	{
		//alert(width);
		$("#form_div").html("");
		$('#popModal').modal({backdrop: 'static', keyboard: false});
		if(width)
			$('.modal-dialog').css('width', width);
		var xmlhttp;
		if (window.XMLHttpRequest)
			xmlhttp=new XMLHttpRequest();
		else
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//alert(xmlhttp.responseText);
				if(xmlhttp.responseText!=0 && xmlhttp.responseText!="")
					$("#form_div").html("&nbsp;"+xmlhttp.responseText);
				else
					$('#popModal').modal("hide");
			}
		}
		xmlhttp.open("POST",strURL,true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send();
	}
	
	function getChangedData(table, where_indicator, where_value, target)
	{
		var strURL="ajax_pages/get_changed_data.php?table="+table+"&where_indicator="+where_indicator+"&where_value="+where_value+"&target="+target;
		//alert("ajax_pages/select_change.php?table="+table+"&where_indicator="+where_indicator+"&where_value="+where_value+"&target="+target);
		var xmlhttp;
		if (window.XMLHttpRequest)
			xmlhttp=new XMLHttpRequest();
		else
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById(target).innerHTML=xmlhttp.responseText;
				//alert(xmlhttp.responseText);
			}
		}
		xmlhttp.open("GET",strURL,true);
		xmlhttp.send();
	}
	</script>
</head>
<body class="body">

<nav class="navbar navbar-default navbar-fixed-top hidden-xs">
	<div class="container-fluid">
		<div class="navbar-header">
			<!--<img src="../images/logo.png" width="50">-->
			<strong><a class="navbar-brand" href="#">
				<big>LTFHC</big></a>
			</strong>
		</div>
		
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<!--<li class="<?php echo $welcome; ?>"><a href="?page=welcome">Home</a></li>-->
				<?php 
				if($permissionRole['0']['view_permission'] ==1){?>
				<li class="<?php echo $screen; ?>"><a href="?page=screen&action=view">Screen</a></li>
				<?php } 
				if($permissionRole['1']['view_permission'] ==1){
				?>
				<li class="<?php echo $layout; ?>"><a href="?page=layout&action=view">Layout</a></li>
				<?php }
				if($permissionRole['2']['view_permission'] ==1){
				?>
				<li class="<?php echo $component; ?>"><a href="?page=component&action=view">Component</a></li>
				<?php }
				if($permissionRole['2']['view_permission'] ==1){
				?>
				<li class="<?php echo $location; ?> dropdown">
					<a href="?parrent_page=location&action=view" class="dropdown-toggle" data-toggle="dropdown">
						Location
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li class="<?php echo $health_zone; ?>"><a href="?page=health_zone&parrent_page=location&action=view">Health Zone</a></li>
						<li class="<?php echo $health_area; ?>"><a href="?page=health_area&parrent_page=location&action=view">Health Area</a></li>
					</ul>
				</li>
				<?php } 
				if($permissionRole['3']['view_permission'] ==1){
				?>
				<li class="<?php echo $user; ?>"><a href="?page=user&action=view"><?php echo $content_lang['22']['content']; ?></a></li>
				<?php } 
				if($permissionRole['4']['view_permission'] ==1){
				?>
				<li class="<?php echo $report; ?>"><a href="?page=report&action=view"><?php echo $content_lang['7']['content']; ?></a></li>
				<?php } 
				if($permissionRole['5']['view_permission'] ==1){
				?>
				<li class="<?php echo $role; ?>"><a href="?page=role&action=view">Role</a></li>
				<?php }
				if($permissionRole['7']['view_permission'] ==1){
				?>
				<li class="<?php echo $language; ?>"><a href="?page=language&action=add">Language</a></li>
				<?php }
				?> 
				<li class="<?php echo $change_password; ?>"><a href="?page=change_password&action=view"><?php echo $content_lang['8']['content']." ".$content_lang['2']['content']; ?> </a></li>
				
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<li><a href="?logout=true"><span class="glyphicon glyphicon-log-out"></span> <?php echo $content_lang['24']['content']; ?></a></li>
			</ul>
		</div>
	</div>
</nav>

<nav class="navbar navbar-default navbar-fixed-top visible-xs">
	<div class="container-fluid">
		<div class="navbar-header">
			<strong><a class="navbar-brand" href="#"><big>LTFHC</big></a></strong>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li class="<?php echo $welcome; ?>"><a href="?page=welcome">Home</a></li>
				<li class="<?php echo $screen; ?>"><a href="?page=screen&action=view">Screen</a></li>
				<li class="<?php echo $layout; ?>"><a href="?page=layout&action=view">Layout</a></li>
				<li class="<?php echo $component; ?>"><a href="?page=component&action=view">Component</a></li>
				<!--<li class="<?php echo $report; ?>"><a href="?page=report&action=view">Report</a></li>-->
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="?logout=true"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>
<div class="container-fluid">
	<div class="row content" style="margin-top:50px">
		<div class="col-sm-12" id="content" style="margin-top:20px">
			<?php include("include/content/$page.php"); ?>
		</div>
	</div>
</div>
<footer class="container-fluid text-center">
	<h4><?php echo $content_lang['15']['content']; ?></h4>
</footer>

</body>
</html>

<!-----------------------Processing circle : Start-------------------------->
<div id="myModal" class="modal fade" role="dialog">
	<div class="loader"></div>
</div>
<!-----------------------Processing circle : End-------------------------->

<!-----------------------Popup : Start-------------------------->
<style>
.modal-body{
    max-height: 550px;
    overflow-y: auto;
}

@media (min-height: 100px) {
    .modal-body { max-height: 450px; }
}
.close{
	//margin-top:15px;
	color:red;
	opacity:10;
}
</style>
<div class="modal fade" id="popModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
		<div>
			<button class="close" id="pop_close" aria-label="close" data-dismiss="modal">&times;</button>
			<div id="form_div">
				<div class="loader"></div>
			</div>
		</div>	
    </div>
</div>
<!-----------------------Popup : End-------------------------->