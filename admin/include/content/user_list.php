
<?php 
//$where=array('a.user_type_id|!='=>'1');
$table1=TBL1;
$where=array("a.user_type_id|!="=>1);
//print_r($permission);
?>

	<script>
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
					window.location="<?php echo $page_name; ?>";
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
				<h3 class="col-sm-10" style="padding:0px;"><?php echo $content_lang['22']['content']." ".$content_lang['31']['content']; ?></h3>
				<?php
				if($permission['add_permission']==1){?>
				<div class="col-sm-2 text-right" style="padding:0px;">
					<a href="?page=<?php echo $page; ?>&action=add" class="btn btn-warning">
						<span class='glyphicon glyphicon-plus'></span>
						<?php echo $content_lang['40']['content']." ".$content_lang['18']['content']; ?>
					</a>
				</div>	
				<?php }?>				
				<div>
					<!--<table class="table table-bordered" style="margin-bottom:5px;">
						<form method="POST">
						<tr class='active'>
							<td>
								<div class="col-sm-3 text-center">
									<select class="form-control" name="filter_user_type_id" id="filter_user_type_id" onchange="this.form.submit();" >
										<option value="">All User Type</option>
										<?php
										/* $detail=$data->getData($con, "a.id, a.name", TBL19." a", array("a.id|!="=>1, "a.status"=>1), "");
										if($detail['status']==1)
										{
											$rslt=$detail['detail'];
											for($i=0; $i<sizeof($rslt); $i++)
											{
												$filter_user_type_id1=$rslt[$i]['id'];
												$filter_user_type_name=$rslt[$i]['name'];
												if($filter_user_type_id1==$filter_user_type_id)
													$selected="selected";
												else
													$selected="";
												echo "<option value='$filter_user_type_id1' $selected>$filter_user_type_name</option>";
											}
										}
										else
											echo "<option value=''>".$detail1['msg']."</option>"; */
										?>
									</select>
								</div> 
							
								<!--<div class="col-sm-3 text-center">
									<button type="submit" name="filter" value="filter" class="btn btn-success btn-block">
										<span class='glyphicon glyphicon-filter'></span>
										Filter
									</button>
								</div>
							</td>
						</tr>
						</form>
					</table> -->
				</div>
				<div class="col-sm-12 text-right" style="padding:0px; margin-top:0px;">
				<?php
				if($_POST['filter_user_type_id']!='')
				{
					$where['a.user_type_id']=$_POST['filter_user_type_id'];
				}
				
				$where['a.status|!=']='2';
				$rslt=$data->countData($con, "a.id", "$table1 a", $where, $other);
									
									if($rslt['status']==1)
									{
										require_once("../class/Pagination.class");
										$page_link=$page_name;
										$start=0;
										$limit=30;
										$numrows=$rslt['count'];
										$pagination = new Pagination($numrows, $start, $limit, $page_link);
										$start=$_REQUEST['start']?$_REQUEST['start']:0;
										echo $pagination->pager($start);
									}
									else
										echo $rslt['msg'];
				?>
				</div>
				<div class="table-responsive1">
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="info">
								<th><?php echo $content_lang['33']['content']; ?></th>
								<th><?php echo $content_lang['34']['content']; ?></th>
								<th><?php echo $content_lang['0']['content']." ".$content_lang['1']['content']; ?></th>
								<th><?php echo $content_lang['23']['content']; ?></th>
								<th><?php echo $content_lang['35']['content']; ?></th>
								<th><?php echo $content_lang['36']['content']; ?></th>
								<th><?php echo $content_lang['38']['content']; ?></th>
							</tr>
						</thead>
						<tbody>
					<?php
						$select="a.id, a.login_id, a.name, a.gender, a.contact, a.email, a.organization, a.location, b.name AS role, a.status";
						$from="$table1 a LEFT JOIN ".TBL66." b ON a.role_id=b.id";
						$detail=$data->getData($con, $select, $from, $where, "LIMIT $start,$limit");
						
						if($detail['status']==1)
						{
							$dtl=$detail['detail'];
							for($i=0; $i<sizeof($dtl); $i++)
							{
								switch($dtl[$i]['status'])
								{
									case 1:
										$class_color="text-primary";
										$glyphicon="glyphicon-eye-open";
										$status_change=0;
										break;
									
									case 0:
										$class_color="text-primary";
										$glyphicon="glyphicon-eye-close";
										$status_change=1;
										break;									
								}
								echo"<tr>";
										echo "<td>".$dtl[$i]['name']."</td>
										<td>".$dtl[$i]['email']."</td>
										<td>".$dtl[$i]['login_id']."</td>
										<td>".$dtl[$i]['role']."</td>
										<td>".$dtl[$i]['organization']."</td>
										<td>".$dtl[$i]['location']."</td>
										<td width='190'>";
										
										if($permission['edit_permission']==1){
											echo "<a href='$page_name&action=edit&id=".$dtl[$i]['id']."' class='btn btn-primary btn-sm'>
												<span class='glyphicon glyphicon-pencil'></span>
												Edit
											</a>&nbsp;&nbsp;";
										}
										if($permission['delete_permission']==1){
											echo "<!--<a href='#' class='btn btn-primary btn-sm' onclick='getDetail(\"$id\", \"$table1\", \"$table2\", \"$table3\")'>
												<span class='glyphicon glyphicon-eye-open'></span>
												View
											</a>-->
											<a href='#' id='link-status' class='$class_color' onclick='changeActivationStatus(\"".$table1."\", \"".$dtl[$i]['id']."\", \"".$status_change."\")'>
											<h4 class='glyphicon $glyphicon'></h4>
										</a>&nbsp;&nbsp;
											<a href='#' id='link-status' class='$class_color' onclick='deleteData(\"".$table1."\", \"".$dtl[$i]['id']."\", \"2\")'>
												<h4 class='glyphicon glyphicon-trash'></h4>
											</a>
										</td>";
										}
									echo "</tr>";
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
				<h4 class="modal-title"><?php echo $content_lang['35']['content']; ?></h4>
			</div>
			<div class="modal-body" id="detail"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="btn-complainInfoClose" data-dismiss="modal"><?php echo $content_lang['44']['content']; ?></button>
			</div>
		</div>
    </div>
 </div>