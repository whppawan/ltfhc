<?php
require_once("include/config.php");
require_once("include/".PAGE6.".php");
require_once("class/Action.class");
require_once ("class/Data.class");
session_start();

if($_REQUEST['language']!='')
	$language = $_REQUEST['language'];
else
	$language = "en";

$table1 =TBL69;	
$data=new Data();
$data_language=$data->getData($con, "id, $language as content", "$table1 a", "", "");
$content_lang = $data_language['detail'];

if(isset($_GET['page'])=='')
	$page="login_form";
else
	$page = $_GET['page'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>LTFHC</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
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
		border: 5px solid #f3f3f3;
		border-radius: 50%;
		border-top: 5px solid blue;
		border-right: 5px solid green;
		border-bottom: 5px solid red;
		border-left: 5px solid pink;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
		
		width: 30px;
		height: 30px;
		position:absolute;
		top:15%;
		left:48%;
		display:none;
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
	
	/************************Google Translate css : Start************************/
	.goog-te-banner-frame{
	display:none !important;
	}
	.goog-logo-link{
	display:none !important;
	}
	.goog-te-gadget {
    color: #555 !important;
    font-size: 30px !important;
}
/************************Google Translate css : End************************/
	</style>
	
	<script>
	$(document).ready(function(){
		$("#btn-login").click(function(){
			if($("#login_id").val()=="")
			{
				alert("Please enter login id");
				$("#login_id").focus();
				return false;
			}
			if($("#password").val()=="")
			{
				alert("Please enter password");
				$("#password").focus();
				return false;
			}
			var form_detail=$("#form_login").serialize();
			$("#form_login :input").prop("disabled", true);
			$(".loader").show();
			$.ajax({
				type: "POST",
				url: "ajax_pages/login.php",
				data: form_detail,
				success: function(response) {
					//alert(response);
					var result=JSON.parse(response);
					if(result.status==1)
						window.location.href=result.location;
					else
					if(result.status==0)
					{
						$(".loader").hide();
						alert(result.msg);
						$("#form_login :input").prop("disabled", false);
					}
					else
					{
						alert(response);
						$(".loader").hide();
					}
				},
				error: function(response) {
					alert("Ajax page cannot be called");
					$(".loader").hide();
					$("#form_login :input").prop("disabled", false);
				}
			});
			return false;
		});
	});
	
function submitForm(form, url, getAddedDataURL, response_div)
	{
		var form_id=form.split("|");
		if(form_id[1])
			var field_id=form_id[1].split(",");
		var dynamic_form_id=form_id[0].split("_", 5);
		$('#myModal').modal({backdrop: 'static', keyboard: false});
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
			//alert(response_div);
			var result=JSON.parse(xmlhttp.responseText);
				if(response_div=="div_mail_response" && result.status=='1')
					{
						$('#form_forgot_password').hide();
						$('#div_mail_response').show();
					}
				else if(response_div=="div_mail_response" && result.status=='0')
					{
						$('#form_forgot_password').hide();
						$('#div_mail_response1').show();
					}
				else { }
			
				$('#myModal').modal("hide");
				if(getAddedDataURL)
				{
					for(var i=0; i<field_id.length; i++)
					{
						//alert($("#"+field_id[i]).val());
						$("#"+field_id[i]).val("");
					}
				}
			}
		}
		xmlhttp.open("POST",url,false);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send($("#"+form_id[0]).serialize());
	}
	
function callPage(url, response_div, sync)
	{
		//$('#myModal').modal({backdrop: 'static', keyboard: false});
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
				//$('#myModal').modal("hide");
				if(response_div)
					$("#"+response_div).html(xmlhttp.responseText);
			}
			//alert(xmlhttp.status);
		}
		xmlhttp.open("GET",url,sync);
		//xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send();
	}
	
	</script>
</head>
<body class="body">

<nav class="navbar navbar-default navbar-fixed-top hidden-xs">
	<div class="container-fluid">
		<div class="navbar-header" style="float:left;">
			<strong><a class="navbar-brand" href="index.php"><big>LTFHC</big></a></strong>
		</div>
		
		<div class="navbar-header" style="float:right;">
			<strong><a class="navbar-brand" href="index.php?language=en"><big>English</big></a></strong>
			<strong><a class="navbar-brand" href="index.php?language=sw"><big>Swahili</big></a></strong>
			<strong><a class="navbar-brand" href="index.php?language=fr"><big>Français</big></a></strong>
		</div>
		
		<div class="collapse navbar-collapse">
			<!--<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>-->
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
			<!--<ul class="nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Projects</a></li>
				<li><a href="#">Contact</a></li>
			</ul>-->
			<!--
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>-->
		</div>
	</div>
</nav>
<div class="container-fluid text-left">
	<div class="row content" style="margin-top:50px">
		<?php include("include/$page.php"); ?>
	</div>
</div>

<footer class="container-fluid text-center navbar-fixed-bottom" style="padding:0px;">
	<h4>Designed & Developed By "<strong>World Health Partners</strong>"</h4>
</footer>

</body>
</html>




