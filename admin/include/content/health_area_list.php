	<script>
	function deleteData(table, id, status_change)
	{
		$('#myModal').modal({backdrop: 'static', keyboard: false});
		var strURL="ajax_pages/save.php?action=edit&table="+table+"&id="+id;
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
		var strURL="ajax_pages/save.php?action=edit&table="+table+"&id="+id;
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
				<h3 class="col-sm-10">Health Area List</h3>
				<div class="col-sm-2 text-right">
					<a href="<?php echo $page_name; ?>&action=add" class="btn btn-warning">
						<span class='glyphicon glyphicon-plus'></span>
						ADD NEW
					</a>
				</div>
				<div>
					<table class="table table-bordered">
						<thead>
							<tr class="info">
								<!--<th>Si.</th>-->
								<!--<th>Id</th>-->
								<th>Name</th>
								<th>Health Area</th>
								<th width="150">Action</th>
							</tr>
						</thead>
						<tbody>
					<?php
							
						$stmt = $con->prepare("SELECT a.id, a.name, a.health_zone_id, b.name AS health_zone_name, a.status FROM $table1 a JOIN ".TBL5." b ON a.health_zone_id=b.id WHERE a.status!=2 ORDER BY a.name") or die($con->error);
						$stmt->execute();
						//$result = $stmt->get_result();
						$stmt->bind_result($id, $name, $health_zone_id, $health_zone_name, $status);
						$i=1;
						while ($stmt->fetch())
						{	
							switch($status)
							{
								case 1:
									$class_color="btn-primary";
									$glyphicon="glyphicon-eye-open";
									$status_cahnge=0;
									break;
								
								case 0:
									$class_color="btn-danger";
									$glyphicon="glyphicon-eye-close";
									$status_cahnge=1;
									break;
								
							}
							echo"<tr class='active'>
									<!--<td>$i</td>-->
									<!--<td>$id</td>-->
									<td>$name</td>
									<td>$health_zone_name</td>
									<td>
										<a href='$page_name&action=edit&id=$id' class='btn btn-primary btn-sm'>
											<span class='glyphicon glyphicon-pencil'></span>
										</a>
										<a href='#' id='link-status' class='btn btn-sm $class_color' onclick='changeActivationStatus(\"".$table1."\", \"".$id."\", \"".$status_cahnge."\")'>
											<span class='glyphicon $glyphicon'></span>
										</a>
										<a href='#' id='link-status' class='btn btn-sm btn-primary' onclick='deleteData(\"".$table1."\", \"".$id."\", \"2\")'>
											<span class='glyphicon glyphicon-trash'></span>
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