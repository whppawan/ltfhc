<?php
require_once ("../class/Data.class");
$data=new Data();
 $viewPermission = $_SESSION['viewPermission'];
if($action=="permission" && $id)
{
$table1 = TBL68;

	$detail=$data->getData($con, "a.id, a.role_id, a.module_id, a.add_permission, a.edit_permission, a.delete_permission, a.view_permission, a.status", "$table1 a", array("role_id"=>$id), "");
	
	$dtl=$detail['detail'];
}
$detail1=$data->getData($con, "a.id, a.name", TBL67." a", array(status=>1), "");
$masterModules=$detail1['detail'];
$countMasterModule = count($masterModules);
$addcount = 0;
$editcount = 0;
$deletecount = 0;
$viewcount = 0;
if($countMasterModule>0)
{
	foreach ($masterModules as $key => $value):
	$moduleId = $value["id"];
	if(($dtl[$key]['add_permission'] == 1) && ($dtl[$key]['module_id']==$moduleId)) {
	$addcount += 1;
	}if(($dtl[$key]['edit_permission'] == 1) && ($dtl[$key]['module_id']==$moduleId)){
		$editcount += 1;
	}if(($dtl[$key]['delete_permission'] == 1) && ($dtl[$key]['module_id']==$moduleId)){
		$deletecount += 1;
	}if(($dtl[$key]['view_permission'] == 1) && ($dtl[$key]['module_id']==$moduleId)){
		$viewcount += 1;
	}

	endforeach;
}
$totaldetails = ($addcount+$editcount+$deletecount+$viewcount);
?>


	
<form method="POST" class="form-horizontal" role="form" id="form" enctype="multipart/form-data">
	<div class="col-sm-12">
		<h3 class="col-sm-8"><?php echo ucfirst($page); ?> List</h3>
		<div class="col-sm-4 text-right">
			<a href="<?php echo $page_name; ?>&action=add" class="btn btn-warning">
				<span class='glyphicon glyphicon-plus'></span>
				ADD NEW
			</a>
			<a href="<?php echo $page_name ?>&action=view" class="btn btn-warning">
				<span class='glyphicon glyphicon-list'></span>
				VIEW LIST
			</a>
		</div>
		<div>
			<table class="table table-bordered">
				<tr class='active'>
					<td>
						<!--<div class="col-sm-10 text-center">
								<?php
								//$detail=$data->getData($con, "a.id, a.name", TBL66." a", "", "");
								//$rslt=$detail['detail'];
									?>
							<select name="role_id" class="form-control" id="role_id" onchange="getRolePermission($(this).val())">
								<?php //foreach ($rslt as $key => $value): ?>
								<option value="<?php //echo $value['id']; ?>" <?php //echo ($value['id'] == $id) ? "selected = 'selected'" : ""; ?>>
									<?php //echo $value['name']; ?>
								</option>                                
								<?php //endforeach; ?>
							</select>
						</div>-->
						<div class="col-sm-3 text-center">
							<?php
							$detail=$data->getData($con, "a.id, a.name", TBL66." a", array(id=>$id), "");
							$rslt=$detail['detail'];
							?>
							<input class="form-control"  type="text" name="role_name" value="<?php echo $rslt[0]['name']; ?>">
							<input class="form-control"  type="hidden" name="role_id" value="<?php echo $id; ?>" >
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="table-responsive1">
			<table class="table table-bordered">
				<thead>
					<tr class="info">
						<th>Details <input class="selectAll " name="chkDetailsAll" type="checkbox" id="chkDetailsAll" onclick="fncCheckDetails()" <?php echo (($countMasterModule*$countMasterModule) == $totaldetails) ? "checked=checked" :""?>></th>
						<th><input class="selectAllAdd " name="chkAddAll" type="checkbox" id="chkAddAll" onclick="fncCheckAdd()" <?php echo ($countMasterModule == $addcount) ? "checked=checked" :""?>>Add</th>
						<th><input class="selectAllEdit" name="chkEditAll" type="checkbox" id="chkEditAll" onclick="fncCheckEdit()" <?php echo ($countMasterModule == $editcount) ? "checked=checked" :""?>>Edit</th>
						<th><input class="selectAllDelete" name="chkDeleteAll" type="checkbox" id="chkDeleteAll" onclick="fncCheckDelete()" <?php echo ($countMasterModule == $deletecount) ? "checked=checked" :""?>>Delete</th>
						<th><input class="selectAllView" name="chkViewAll" type="checkbox" id="chkViewAll" onclick="fncCheckView()" <?php echo ($countMasterModule == $viewcount) ? "checked=checked" :""?>>View</th>
					</tr>
				</thead>
				<tbody>
						<?php
						if($countMasterModule>0)
						{
							foreach ($masterModules as $key => $value):	$moduleId = $value["id"]; 
							if($moduleId==5 || $moduleId==7)
								$chlbx_disabled="disabled";
							else
								$chlbx_disabled="";
						?>
							<tr>
								<td><?php echo $value['name']; ?></td>
								<td>
									<?php if(($dtl[$key]['add_permission'] == 1) && ($dtl[$key]['module_id']==$moduleId)) { ?>
									<input name="chkAdd[<?php echo $value['name']; ?>]"  value="<?php echo $moduleId; ?>" onchange="checkView('<?php echo $moduleId ?>')" id="chkAdd<?php echo $moduleId; ?>" type="checkbox" class="add" checked <?php echo $chlbx_disabled; ?> >
									<?php } else { ?>
									<input name="chkAdd[<?php echo $value['name']; ?>]"  value="<?php echo $moduleId; ?>" onchange="checkView('<?php echo $moduleId ?>')" id="chkAdd<?php echo $moduleId; ?>" type="checkbox" class="add" <?php echo $chlbx_disabled; ?> >
									<?php } ?>                    
								</td>
								<td>
									<?php if($dtl[$key]['edit_permission'] == 1 && ($dtl[$key]['module_id']==$moduleId)) { ?>
									<input name="chkEdit[<?php echo $value['name']; ?>]"  value="<?php echo $moduleId; ?>"  onclick="checkView('<?php echo $moduleId ?>')"  id="chkEdit<?php echo $moduleId; ?>" type="checkbox" class="addedit" checked <?php echo $chlbx_disabled; ?> >
									<?php } else { ?>
									<input name="chkEdit[<?php echo $value['name']; ?>]"  value="<?php echo $moduleId; ?>"  onclick="checkView('<?php echo $moduleId ?>')"  id="chkEdit<?php echo $moduleId; ?>" type="checkbox" class="addedit" <?php echo $chlbx_disabled; ?> >
									<?php } ?>                                                                    
								</td>
								<td>
									<?php if($dtl[$key]['delete_permission'] == 1 && ($dtl[$key]['module_id']==$moduleId)) { ?>
									<input name="chkDelete[<?php echo $value['name']; ?>]"  value="<?php echo $moduleId; ?>"   onclick="checkView('<?php echo $moduleId ?>')"  id="chkDelete<?php echo $moduleId; ?>" type="checkbox" class="adddelete" checked <?php echo $chlbx_disabled; ?> >
									<?php } else { ?>
									<input name="chkDelete[<?php echo $value['name']; ?>]"  value="<?php echo $moduleId; ?>"   onclick="checkView('<?php echo $moduleId ?>')"  id="chkDelete<?php echo $moduleId; ?>" type="checkbox" class="adddelete" <?php echo $chlbx_disabled; ?> >
									<?php } ?>                                                                    
								</td>
								<td>
									<?php if($dtl[$key]['view_permission']== 1 && ($dtl[$key]['module_id']==$moduleId)) { ?>
									<input name="chkView[<?php echo $value['name']; ?>]"  value="<?php echo $moduleId; ?>" id="chkView<?php echo $moduleId; ?>" type="checkbox"  onclick="viewCheck('<?php echo $moduleId ?>')" class="addview" checked>
									<?php } else { ?>
									<input name="chkView[<?php echo $value['name']; ?>]"  value="<?php echo $moduleId; ?>" id="chkView<?php echo $moduleId; ?>" type="checkbox"  onclick="viewCheck('<?php echo $moduleId ?>')" class="addview">
									<?php } ?>                                                                    
								</td>
							</tr>
						<?php 
							endforeach; 
						}
						?>
					</tbody>
			</table>
		</div>
	</div>
	<div class="col-sm-12 text-center" style="margin-bottom:10px;">
		<button type="submit" name="filter" value="filter" class="btn btn-danger" id="btn-submit">
			Submit
		</button>
	</div>
</form>

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
				alert(xmlhttp.responseText);
				var result=JSON.parse(xmlhttp.responseText);
				if(result.status==1)
				{
					alert(result.msg);
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
	function getRolePermission(roleId)
    {
        roleId = btoa(roleId);
        
        $.ajax({
            url : '/roles/get-roles-permission',
            type : 'POST',
            datatype : 'HTML',
            data : 'roleId='+roleId,
            success : function(data) {
                $("#rolePermission").html(data);
             }
         });
    }
    
    function checkView(key)
    {
		$("#chkView"+key).parent().addClass('checked');
        $("#chkView"+key).prop("checked", true);
    }
    
    function viewCheck(key)
    {      
        if( $("#chkView"+key).prop('checked')) { 
            /*$("#chkAdd"+key).parent().addClass('checked');
            $("#chkAdd"+key).prop("checked", true);
            
            $("#chkEdit"+key).parent().addClass('checked');
            $("#chkEdit"+key).prop("checked", true);
            
            $("#chkDelete"+key).parent().addClass('checked');
            $("#chkDelete"+key).prop("checked", true);*/
        }
        else {
            $("#chkAdd"+key).parent().removeClass('checked');
			$("#chkAdd"+key).prop("checked", false);
            $("#chkEdit"+key).parent().removeClass('checked');
			$("#chkEdit"+key).prop("checked", false);
            $("#chkDelete"+key).parent().removeClass('checked');
			$("#chkDelete"+key).prop("checked", false);
        }
    }

    function fncCheckAdd()
    {
        if( document.getElementById('chkAddAll').checked) {
            $(".add").parent().addClass('checked');
            $(".add").prop("checked", true);

            $(".selectAllAdd").parent().addClass('checked');
            $(".selectAllAdd").prop("checked", true);

            $(".selectAllView").parent().addClass('checked');
            $(".selectAllView").prop("checked", true);

            $(".addview").parent().addClass('checked');
            $(".addview").prop("checked", true);

        }
        else {
            $(".add").parent().removeClass('checked');
            $(".add").prop("checked", false);
            $(".selectAllAdd").parent().removeClass('checked');
        }
    }
    
    function fncCheckEdit()
    {
        if( document.getElementById('chkEditAll').checked) {
            $(".addedit").parent().addClass('checked');
            $(".addedit").prop("checked", true);

            $(".selectAllEdit").parent().addClass('checked');
            $(".selectAllEdit").prop("checked", true);

            $(".selectAllView").parent().addClass('checked');
            $(".selectAllView").prop("checked", true);

            $(".addview").parent().addClass('checked');
            $(".addview").prop("checked", true);

        } 
        else {
            $(".addedit").parent().removeClass('checked');
            $(".addedit").prop("checked", false);
            $(".selectAllEdit").parent().removeClass('checked'); 
        }   
    }
   
    function fncCheckDelete()
    {
        if( document.getElementById('chkDeleteAll').checked) {
            $(".adddelete").parent().addClass('checked');
            $(".adddelete").prop("checked", true);

            $(".selectAllDelete").parent().addClass('checked');
            $(".selectAllDelete").prop("checked", true);

            $(".selectAllView").parent().addClass('checked');
            $(".selectAllView").prop("checked", true);

            $(".addview").parent().addClass('checked');
            $(".addview").prop("checked", true);

        }
        else {
            $(".adddelete").parent().removeClass('checked');
            $(".adddelete").prop("checked", false);
            $(".selectAllDelete").parent().removeClass('checked'); 
        }   
    }
    
    function fncCheckView()
    {
        if(document.getElementById('chkViewAll').checked) {
            $(".addview").parent().addClass('checked');
            $(".addview").prop("checked", true);
        }
        else {
            $(".addview").parent().removeClass('checked');
            $(".addview").prop("checked", false);
        }
    }
    
    function fncCheckDetails()
    {
        if(document.getElementById('chkDetailsAll').checked) {
           $(".selectAllAdd").parent().addClass('checked');
           $(".selectAllAdd").prop("checked", true);
           
           $(".add").parent().addClass('checked');
           $(".add").prop("checked", true);
           
           $(".selectAllEdit").parent().addClass('checked');
           $(".selectAllEdit").prop("checked", true);
           
           $(".addedit").parent().addClass('checked');
           $(".addedit").prop("checked", true);
           
           $(".selectAllDelete").parent().addClass('checked');
           $(".selectAllDelete").prop("checked", true);
           
           $(".adddelete").parent().addClass('checked');
           $(".adddelete").prop("checked", true);
           
           $(".selectAllView").parent().addClass('checked');
           $(".selectAllView").prop("checked", true);
           
           $(".addview").parent().addClass('checked');
           $(".addview").prop("checked", true);
       }
       else{
           $(".add").parent().removeClass('checked');
           $(".add").prop("checked", false);
           $(".selectAllAdd").parent().removeClass('checked'); 
           $(".selectAllAdd").prop("checked", false);		   
           $(".addedit").parent().removeClass('checked');
           $(".addedit").prop("checked", false);
           $(".selectAllEdit").parent().removeClass('checked');  
		   $(".selectAllEdit").prop("checked", false);
           $(".adddelete").parent().removeClass('checked');
           $(".adddelete").prop('checked', false);
           $(".selectAllDelete").parent().removeClass('checked');
		   $(".selectAllDelete").prop("checked", false);
           $(".addview").parent().removeClass('checked');
           $(".addview").prop('checked', false);
           $(".selectAllView").parent().removeClass('checked');
		   $(".selectAllView").prop("checked", false);
       }
    }
	
	$(document).ready(function(){
		
		/*Jquery Ajax function to call the PHP page which saves the data of the form*/
		$("form#form").submit(function(){
			var form_data = new FormData(this);
			//var form_data = $("#form").serialize();
			//alert(form_data);                    
			
				$('#myModal').modal({backdrop: 'static', keyboard: false});
				$.ajax({
					type: "POST",
					url: "ajax_pages/save.php?action=<?php echo $action; ?>&table=<?php echo $table1; ?>&id=<?php echo $id; ?>",
					//data: $("#form").serialize(),
					data: form_data,
					cache: false,
					contentType: false,
					processData: false,
					success: function(response) {
						//alert(response);
						var result=JSON.parse(response);
						if(result.status==1)
						{
							alert(result.msg);
							window.location="index.php<?php echo $page_name; ?>&action=<?php echo $action; ?>&id=<?php echo $id; ?>";
						}
						else
						if(result.status==0)
						{
							alert(result.msg);
							$('#myModal').modal("hide");
						}
					},
					error: function(response) {
						alert(response);
					}
				});
			
			return false;
		});
	});
	</script>