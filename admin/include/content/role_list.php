	<script>
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
					alert(result.msg);
					window.location="index.php<?php echo $page_name; ?>&action=view&start=<?php echo $start; ?>";
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
	<h3 class="col-sm-10"><?php echo ucfirst($page); ?> List</h3>
	<div class="col-sm-2 text-right">
		<a href="<?php echo $page_name; ?>&action=add" class="btn btn-warning">
			<span class='glyphicon glyphicon-plus'></span>
			ADD NEW
		</a>
	</div>						
	
	<div class="table-responsive1">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th width='200'>Name</th>
					<th width='50'>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$where=array("a.id|!="=>1);
			
				$detail=$data->getData($con, "a.id, a.name, a.status", "$table1 a", $where, "ORDER BY a.id DESC");
				if($detail['status']==1)
				{
					$dtl=$detail['detail'];
					for($i=0; $i<sizeof($dtl); $i++)
					{
						switch($dtl[$i]['status'])
						{
							case 1:
								$class_color="text-success";
								$glyphicon="glyphicon-ok";
								$status_change=0;
								break;
						
							case 0:
								$class_color="text-danger";
								$glyphicon="glyphicon-remove";
								$status_change=1;
								break;
						}
						echo"<tr class='active'>
								<td>".$dtl[$i]['name']."</td>
								<td>
								<a href='$page_name&action=permission&id=".$dtl[$i]['id']."' class='btn btn-primary btn-sm'>
										<span class='glyphicon glyphicon-pencil'></span>
										Edit Permissions
									</a>
									<!--<a href='$page_name&action=edit&id=".$dtl[$i]['id']."' class='btn btn-primary btn-sm'>
										<span class='glyphicon glyphicon-pencil'></span>
										Edit
									</a>
									<a href='#' class='btn btn-primary btn-sm' onclick='getDetail(\"$id\", \"$table1\", \"$table2\", \"$table3\")'>
										<span class='glyphicon glyphicon-eye-open'></span>
										View
									</a>
									<a href='#' id='link-status' class='$class_color' onclick='changeActivationStatus(\"".$table1."\", \"".$dtl[$i]['id']."\", \"".$status_change."\")'>
										<span class='glyphicon $glyphicon'></span>
									</a>-->
								</td>
							</tr>";
					}
				}
				else
					echo "<tr class='active'><td colspan=10>".$detail['msg']."</tr></td>";
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