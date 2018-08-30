<?php
require_once("../include/config.php");
require_once("../include/".PAGE6.".php");

error_reporting(E_ALL ^ E_NOTICE);
session_start();

$login_id=$_SESSION[APPLICATION_ID.'_login_id'];
$login_name=$_SESSION[APPLICATION_ID.'_login_name'];
$login_type=$_SESSION[APPLICATION_ID.'_login_type'];
$login_sub_type=$_SESSION[APPLICATION_ID.'_login_sub_type'];
$login_session_path=LOGIN_SESSION_PATH."$login_type/";
$login_session_time=LOGIN_SESSION_TIME;
 
if(!$login_id || $_REQUEST['logout']=="true")
	header("Location: ../".PAGE1.".php?logout=true");

$date=date("Y-m-d");

if($patient_detail=$_SESSION[APPLICATION_ID.'_patient_detail'])
{
	$disable="";
	$patient_detail_container_display="";
}
else
{
	$disable="disabled";
	$patient_detail_container_display="none";
}

$visit_date=$patient_detail['visit_date'] ? $patient_detail['visit_date'] : $date;
$page=$patient_detail['page'] ? $patient_detail['page'] : "welcome";
$patient_id=$patient_detail['patient_id'] ? $patient_detail['patient_id'] : $_SESSION['3_patient_id'];
$trimester=$patient_detail['trimester'];
$last_trimester=$_SESSION[APPLICATION_ID.'_last_trimester'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ANC</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	<!-----------------------------------Calendar : Start-------------------------------->
	<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
	<!-----------------------------------Calendar : End-------------------------------->
	<style>
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
	
	<script>
	$(document).ready(function(){
		$("#btn-patient_search").click(function(){
			if($("#search_patient_id").val()=="")
			{
				alert("Please fill patient id");
				return false;
			}
			$('#myModal').modal({backdrop: 'static', keyboard: false});
			
			$.ajax({
				type: "POST",
				url: "ajax_pages/search_patient.php",
				data: $("#form-patient_search").serialize(),
				success: function(response) {
					
					//alert(response);
					var result=JSON.parse(response);
					if(result.status==1)
					{
						//alert(result.last_trimester);
						window.location="index.php";
						/*switch(result.last_trimester)
						{
							case "2":
								$("#trimester option[value=1]").hide();
								break;
							case "3-1":
								$("#trimester option[value=1]").hide();
								$("#trimester option[value=2]").hide();
								break;
							case "3-2":
								$("#trimester option[value=1]").hide();
								$("#trimester option[value=2]").hide();
								$("#trimester option[value=3-1]").hide();
								break;
						}
						$("#trimester").prop("disabled", false);
						$("#trimester").prop("selectedIndex", 0);
						$("#content").load("include/content/welcome.php");
						
						$('#myModal').modal('hide');*/
					}
					else
					if(result.status==0)
					{
						$('#myModal').modal('hide');
						$("#trimester").prop("disabled", true);
						$("#trimester").prop("selectedIndex", 0);
						alert(result.msg);
					}
					else
						alert(response);
				},
				error: function(response) {
					alert(response);
				}
			});
			return false;
		});
		
		$("#trimester").change(function(){
			var trimester=$("#trimester").val();
			if(trimester)
			{
				$('#myModal').modal({backdrop: 'static', keyboard: false});
				$.ajax({
					type: "POST",
					url: "ajax_pages/search_patient.php",
					data: 	{
								visit_date: $("#search_visit_date").val(),
								patient_id: $("#search_patient_id").val(),
								trimester: $("#trimester").val()
							},
					success: function(response)
					{
						//alert(response);
						var result=JSON.parse(response);
						if(result.status==1)
						{
							window.location="index.php";
						}
						else
						if(result.status==0)
							alert(result.msg);
						else
							alert(response);
					},
					error: function(response) {
						alert(response);
					}
				});
			}
			else
				$( "#content" ).load("include/content/welcome.php");
			
			return false;
		});
	});
	</script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top hidden-xs">
	<div class="container-fluid">
		<div class="navbar-header">
			<strong><a class="navbar-brand" href="#"><big>Antenatal Care</big></a></strong>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="?logout=true"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<nav class="navbar navbar-default navbar-fixed-top visible-xs">
	<div class="container-fluid">
		<div class="navbar-header">
			<strong><a class="navbar-brand" href="#"><big>Antenatal Care</big></a></strong>
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
			<ul class="nav navbar-nav navbar-right">
				<li><a href="?logout=true"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container-fluid text-left">
	<div class="row content" style="margin-top:50px">
		<div class="col-sm-4 text-left" style="margin-top:20px">
			<div class="well">
				<form role="form" id="form-patient_search">
					<div class="form-group input-group date" id="datetimepicker1">
						<input type="text" name="visit_date" class="form-control" id="search_visit_date"  value="<?php echo $visit_date; ?>" readonly>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
					<script type="text/javascript">
					$(function () {
						$('#datetimepicker1').datetimepicker({
							format: 'YYYY-MM-DD',
							ignoreReadonly: true
						});
					});
					</script>
					<div class="form-group input-group">
						<input type="text" name="patient_id" class="form-control" id="search_patient_id" value="<?php echo $patient_id; ?>" placeholder="Patient Id">
						<span class="input-group-btn">
							<button class="btn btn-default" id="btn-patient_search" type="button">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>
					<!--<div class="form-group input-group">
						<button class="btn btn-danger" type="button">Search</button>
					</div>-->
					
				</form>
			</div>
			<div class="well">
				<form role="search" id="form-trimester">
					<div class="form-group">
						<?php
						if($trimester=="1")
							$ft="selected";
						else
						if($trimester=="2")
							$st="selected";
						else
						if($trimester=="3-1")
							$tt1="selected";
						else
						if($trimester=="3-2")
							$tt2="selected";
						else
						if($trimester=="4")
							$ds="selected";
						?>
						<select class="form-control" id="trimester" name="trimester" id="trimester" <?php echo $disable; ?>>
							<option value="">Select Trimester</option>
							<?php if($last_trimester=="2"){ ?>
							<option value="2" <?php echo $st; ?>>Second Trimester</option>
							<option value="3-1" <?php echo $tt1; ?>>Third Trimester (28th Week to 36 Week)</option>
							<option value="3-2" <?php echo $tt2; ?>>Third Trimester (37 Week and above)</option>
							<option value="4" <?php echo $ds; ?>>Delivery Status</option>
							<?php }else if($last_trimester=="3-1"){ ?>
							<option value="3-1" <?php echo $tt1; ?>>Third Trimester (28th Week to 36 Week)</option>
							<option value="3-2" <?php echo $tt2; ?>>Third Trimester (37 Week and above)</option>
							<option value="4" <?php echo $ds; ?>>Delivery Status</option>
							<?php }else if($last_trimester=="3-2"){ ?>
							<option value="3-2" <?php echo $tt2; ?>>Third Trimester (Second Visit)</option>
							<option value="4" <?php echo $ds; ?>>Delivery Status</option>
							<?php }else if($last_trimester=="4"){ ?>
							<option value="4" <?php echo $ds; ?>>Delivery Status</option>
							<?php }else{ ?>
							<option value="1" <?php echo $ft; ?>>First Trimester</option>
							<option value="2" <?php echo $st; ?>>Second Trimester</option>
							<option value="3-1" <?php echo $tt1; ?>>Third Trimester (28th Week to 36 Week)</option>
							<option value="3-2" <?php echo $tt2; ?>>Third Trimester (37 Week and above)</option>
							<option value="4" <?php echo $ds; ?>>Delivery Status</option>
							<?php } ?>
						</select>
					</div>
				</form>
			</div>
			<div class="well form-horizontal" style="display:<?php echo $patient_detail_container_display; ?>">
				<h4>Patient Detail :-</h4>
				<div class="form-group">
					<span class="col-sm-6 text-right">Name :</span>
					<div class="col-sm-6"><?php echo $patient_detail['name']; ?></div>
				</div>
				<div class="form-group">
					<span class="col-sm-6 text-right">Age :</span>
					<div class="col-sm-6"><?php echo $patient_detail['age']; ?></div>
				</div>
				<div class="form-group">
					<span class="col-sm-6 text-right">Gender :</span>
					<div class="col-sm-6"><?php echo $patient_detail['gender']; ?></div>
				</div>
				<div class="form-group">
					<span class="col-sm-6 text-right">District :</span>
					<div class="col-sm-6"><?php echo $patient_detail['district_name']; ?></div>
				</div>
				<div class="form-group">
					<span class="col-sm-6 text-right">Block :</span>
					<div class="col-sm-6"><?php echo $patient_detail['block_name']; ?></div>
				</div>
				<div class="form-group">
					<span class="col-sm-6 text-right">Village :</span>
					<div class="col-sm-6"><?php echo $patient_detail['village_name']; ?></div>
				</div>
				<div class="form-group">
					<span class="col-sm-6 text-right">Father / Husband Name :</span>
					<div class="col-sm-6"><?php echo $patient_detail['father_husband_name']; ?></div>
				</div>
				<div class="form-group">
					<span class="col-sm-6 text-right">Contact :</span>
					<div class="col-sm-6"><?php echo $patient_detail['contact']; ?></div>
				</div>
			</div>
		</div>
		<div class="col-sm-8 text-left" id="content" style="margin-top:20px">
			<?php include("include/content/$page.php"); ?>
		</div>
	</div>
</div>
<footer class="container-fluid text-center">
	<h4>Designed & Developed By "<strong>World Health Partners</strong>"</h4>
</footer>

</body>
</html>


<div id="myModal" class="modal fade" role="dialog">
	<div class="loader"></div>
</div>