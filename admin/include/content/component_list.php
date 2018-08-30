	<script>
	/*Ajax function to call the page which change the status of the clicked record without refreshing the current page*/
	function deleteData(table, id, status_change)
	{
		$('#myModal').modal({backdrop: 'static', keyboard: false});
		var strURL="ajax_pages/save_data.php?action=edit&table="+table+"&id="+id;
		var xmlhttp;
		if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();} else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//alert(xmlhttp.responseText);
				var result=JSON.parse(xmlhttp.responseText);
				if(result.status==1)
				{
					//alert(result.msg);
					window.location="index.php<?php echo $page_name; ?>&action=view";
				}
				else
					alert(result.msg);
				ext;
			}
		}
        xmlhttp.open("POST",strURL,true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("status="+status_change);
	}
	
	function changeActivationStatus(table, id, status_change)
	{
		$('#myModal').modal({backdrop: 'static', keyboard: false});
		var strURL="ajax_pages/save_data.php?action=edit&table="+table+"&id="+id;
		var xmlhttp;
		if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();} else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//alert(xmlhttp.responseText);
				var result=JSON.parse(xmlhttp.responseText);
				if(result.status==1)
				{
					//alert(result.msg);
					window.location="index.php<?php echo $page_name; ?>&action=view";
				}
				else
					alert(result.msg);
				ext;
			}
		}
        xmlhttp.open("POST",strURL,true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("status="+status_change);
	}
	/*Ajax function to call the page which give layout name according to the selected screen without refreshing the current page*/
	function getLayout(table, screen_id)
	{
		var strURL="ajax_pages/get_layout.php";
		//alert(screen_id);
		var xmlhttp;
		if (window.XMLHttpRequest)
			xmlhttp=new XMLHttpRequest();
		else
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
				document.getElementById("search_layout_id").innerHTML=xmlhttp.responseText;
		}
		xmlhttp.open("POST",strURL,true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("table="+table+"&screen_id="+screen_id);
	}
	/*Jquery Ajax function to call the page which give all the detail of the clicked record without refreshing the current page*/
	function getDetail(id, table1, table2, table3)
	{
		$.ajax({
			type: "POST",
			url: "ajax_pages/get_component_detail.php",
			data: {id : id, table1 : table1, table2 : table2, table3 : table3},
			success: function(response) {
				$('#detail').html(response);
				$('#detailModal').modal({backdrop: 'static', keyboard: false});					
			},
			error: function(response) {
				alert("Error : "+response);
			}
		});
	}
	</script>
			<div>
				<h3 class="col-sm-10">Component List</h3>
				<div class="col-sm-2 text-right">
					<a href="?page=<?php echo $page; ?>&action=add" class="btn btn-warning">
						<span class='glyphicon glyphicon-plus'></span>
						ADD NEW
					</a>
				</div>
				<div>
					<!--<table class="table">
						<form method="POST">
						<tr class='active table-bordered'>
							<td>
								<select class='form-control' name="search_screen_id" onchange="getLayout('<?php echo $table2; ?>', this.value)">
								<option value="">Select Screen</option>
								<?php
								$$search_screen_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table3 a WHERE a.status=1 ORDER BY a.name") or die($con->error);
								$stmt->execute();
								//$result = get_result($stmt);
								$stmt->bind_result($screenid, $screen_name);
								while ($stmt->fetch())
								{
									$screen_selected=$$screenid;
									
									echo "<option value='$screenid' $screen_selected>$screen_name</option>";
								}
								$$search_screen_id="";
								$stmt->close();
								?>								
								</select>
							</td>
							<td>
								<select class='form-control' name="search_layout_id" id="search_layout_id">
								<option value="">Select Layout</option>
								<?php
								$$search_layout_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table2 a WHERE a.status=1 $layout_where ORDER BY a.screen_id, a.sequence") or die($con->error);
								$stmt->execute();
								//$result = get_result($stmt);
								$stmt->bind_result($layoutid, $layout_name);
								while ($stmt->fetch())
								{
									$layout_selected=$$layoutid;
									
									echo "<option value='$layoutid' $layout_selected>$layout_name</option>";
								}
								$$search_layout_id="";
								$stmt->close();
								?>								
								</select>
							</td>
							<td class="text-center">
								<button type="submit" class="btn btn-success">
									<span class='glyphicon glyphicon-filter'></span>
									Filter
								</button>
							</td>
						</tr>
						</form>
					</table>-->
					
					<table class="table">
						<form method="POST">
						<tr class='active table-bordered'>
							<td>
								<select class='form-control' name="search_screen_id" onchange="this.form.submit();">
								<option value="">Select Screen</option>
								<?php
								$$search_screen_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table3 a WHERE a.status=1 ORDER BY a.name") or die($con->error);
								$stmt->execute();
								//$result = get_result($stmt);
								$stmt->bind_result($screenid, $screen_name);
								while ($stmt->fetch())
								{
									$screen_selected=$$screenid;
									
									echo "<option value='$screenid' $screen_selected>$screen_name</option>";
								}
								$$search_screen_id="";
								$stmt->close();
								?>								
								</select>
							</td>
							<td>
								<select class='form-control' name="search_layout_id" id="search_layout_id" onchange="this.form.submit();">
								<option value="">Select Layout</option>
								<?php
								$$search_layout_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table2 a WHERE a.status=1 $layout_where ORDER BY a.screen_id, a.sequence") or die($con->error);
								$stmt->execute();
								//$result = get_result($stmt);
								$stmt->bind_result($layoutid, $layout_name);
								while ($stmt->fetch())
								{
									$layout_selected=$$layoutid;
									
									echo "<option value='$layoutid' $layout_selected>$layout_name</option>";
								}
								$$search_layout_id="";
								$stmt->close();
								?>								
								</select>
							</td>
						</tr>
						</form>
					</table>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr class="info">
								<!--<th>Si.</th>-->
								<!--<th>Component Id</th>-->
								<th>Component Name</th>
								<th>Component Type</th>
								<th>Save Value</th>
								<!--<th>Component Option</th>-->
								<th>Default Value</th>
								<!--<th>Component Attribute</th>-->
								<th>Onclick Target</th>
								<th>Onclick Target Value</th>
								<th>Layout</th>
								<th>Screen</th>
								<th>Sequence</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<!--<tr>
								<td colspan="13" align="right">
									<?php
										/*$stmt = $con->prepare("SELECT a.id FROM $table1 a LEFT JOIN $table2 b ON a.layout_id=b.id AND b.status=1 LEFT JOIN $table3 c ON a.screen_id=c.id LEFT JOIN $table3 d ON a.onclick_target_value_id=d.id AND c.status=1 WHERE a.id!='' $where");
										if(!$con->error)
										{
											//$stmt->bind_param("s", $id); 
											$stmt->execute();
											$stmt->store_result();

											require_once("../class/Pagination.class");
											$page_link="?page=$page";
											$start=0;
											$limit=10;
											$numrows=$stmt->num_rows;
											$pagination = new Pagination($numrows, $start, $limit, $page_link);
											$start=$_REQUEST['start']?$_REQUEST['start']:0;
											echo $pagination->pager($start);
										}*/
									?>
								</td>
							</tr>-->
					<?php
							
						$stmt = $con->prepare("SELECT a.id, a.en_name, a.fr_name, a.sw_name, a.type, a.save_value, a.en_options, a.fr_options, a.sw_options, a.default_value, a.en_attribute, a.fr_attribute, a.sw_attribute, a.onclick_function, a.onclick_target, d.name, b.name, c.name, a.sequence, a.status FROM $table1 a JOIN $table2 b ON a.layout_id=b.id AND b.status=1 JOIN $table3 c ON a.screen_id=c.id AND c.status=1 LEFT JOIN $table3 d ON a.onclick_target_value_id=d.id WHERE a.status!=2 $where ORDER BY c.name, b.sequence, a.sequence") or die($con->error);
						$stmt->execute();
						//$result = $stmt->get_result();
						$stmt->bind_result($id, $en_name, $fr_name, $sw_name, $type, $save_value, $en_options, $fr_options, $sw_options, $default_value, $en_attribute, $fr_attribute, $sw_attribute, $onclick_function, $onclick_target, $onclick_target_value, $layout_name, $screen_name, $sequence, $status);
						$i=1;
						while ($stmt->fetch())
						{
							switch($status)
							{
								case 1:
									$class_color="text-primary";
									$glyphicon="glyphicon-eye-open";
									$status_cahnge=0;
									break;
								
								case 0:
									$class_color="text-primary";
									$glyphicon="glyphicon-eye-close";
									$status_cahnge=1;
									break;
								
							}
							echo"<tr class='active'>
									<!--<td>$i</td>-->
									<!--<td>$id</td>-->
									<td>$en_name<br>$fr_name<br>$sw_name</td>
									<td>$type</td>
									<td>$save_value</td>
									<!--<td>$en_options</td>-->
									<td>$onclick_function</td>
									<td>$onclick_target</td>
									<td>$onclick_target_value</td>
									<td>$layout_name</td>
									<td>$screen_name</td>
									<td>$sequence</td>
									<td width='190'>
										<a href='$page_name&action=edit&id=$id' class='btn btn-primary btn-sm'>
											<span class='glyphicon glyphicon-pencil'></span>
											Edit
										</a>
										<a href='#' class='btn btn-primary btn-sm' onclick='getDetail(\"$id\", \"$table1\", \"$table2\", \"$table3\")'>
											<span class='glyphicon glyphicon-eye-open'></span>
											View
										</a>
										<a href='#' id='link-status' class='$class_color' onclick='changeActivationStatus(\"".TBL17."\", \"".$id."\", \"".$status_cahnge."\")'>
											<h4 class='glyphicon $glyphicon'></h4>
										</a>
										<a href='#' id='link-status' class='$class_color' onclick='deleteData(\"".TBL17."\", \"".$id."\", \"2\")'>
											<h4 class='glyphicon glyphicon-trash'></h4>
										</a>
									</td>
								</tr>";
							$i++;
						}
					?>
						</tbody>
					</table>
				</div>
			</div>

<style>
.modal-body{
    max-height: 550px;
    overflow-y: auto;
}

@media (min-height: 100px) {
    .modal-body { max-height: 450px; }
}

</style>			
<div class="modal fade" id="detailModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" id="ico-complainInfoClose" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Detail</h4>
			</div>
			<div class="modal-body" id="detail"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="btn-complainInfoClose" data-dismiss="modal">Close</button>
			</div>
		</div>
    </div>
 </div>