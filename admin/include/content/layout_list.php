	<script>
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
	
	/*Ajax function to call the page which change the status of the clicked record without refreshing the current page*/
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
	</script>
			<div>
				<h3 class="col-sm-10">Layout List</h3>
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
								<select class='form-control' name="search_screen_id">
								<option value="">Select Screen</option>
								<?php
								$$search_screen_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table2 a WHERE a.status=1 ORDER BY a.name") or die($con->error);
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
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table2 a WHERE a.status=1 ORDER BY a.name") or die($con->error);
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
						</tr>
						</form>
					</table>
				</div>
				<div>
					<table class="table table-bordered">
						<thead>
							<tr class="info">
								<!--<th>Si.</th>-->
								<!--<th>Layout Id</th>-->
								<th>Layout Name</th>
								<th>Layout Type</th>
								<th>Layout Orientation</th>
								<th>Layout Attribute</th>
								<!--<th>Parrent Layout</th>-->
								<!--<th>Screen Id</th>-->
								<th>Screen Name</th>
								<th>Sequence</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<!--<tr>
								<td colspan="13" align="right">
									<?php
										/*$stmt = $con->prepare("SELECT a.id FROM $table1 a JOIN $table2 b ON a.screen_id=b.id WHERE a.id!='' $where");
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
						$stmt = $con->prepare("SELECT a.id, a.name, a.type, a.orientation, a.attribute, c.name, b.name, a.screen_id, a.sequence, a.status FROM $table1 a JOIN $table2 b ON a.screen_id=b.id AND b.status!=2 LEFT JOIN $table1 c ON a.parent_layout_id=c.id WHERE a.status!=2 $where ORDER BY b.name, a.sequence") or die($con->error);
						$stmt->execute();
						//$result = $stmt->get_result();
						$stmt->bind_result($id, $name, $type, $orientation, $attribute, $parent_layout_name, $screen, $screen_id, $sequence, $status);
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
									<td>$name</td>
									<td>$type</td>
									<td>$orientation</td>
									<td>$attribute</td>
									<!--<td>$parent_layout_name</td>-->
									<!--<td>$screen_id</td>-->
									<td>$screen</td>
									<td>$sequence</td>
									<td>
										<a href='$page_name&action=edit&id=$id' class='btn btn-primary btn-sm'>
											<span class='glyphicon glyphicon-pencil'></span>
											Edit
										</a>
										<a href='#' id='link-status' class='$class_color' onclick='changeActivationStatus(\"".$table1."\", \"".$id."\", \"".$status_cahnge."\")'>
											<h4 class='glyphicon $glyphicon'></h4>
										</a>
										<a href='#' id='link-status' class='$class_color' onclick='deleteData(\"".$table1."\", \"".$id."\", \"2\")'>
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