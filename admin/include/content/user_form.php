<?php
require_once ("../class/Data.class");

$data=new Data();
$dtl[0]['status']=1;
if($action=="edit" && $id)
{
	$detail=$data->getData($con, "a.*", "$table1 a", array("id"=>$id), "");
	$dtl=$detail['detail'];
	$imageUrl="..";
}

?>							
	<script>
	$(document).ready(function(){
		
		/*Jquery Ajax function to call the PHP page which saves the data of the form*/
		$("form#form").submit(function(){
			var form_data = new FormData(this);
			//var form_data = $("#form").serialize();
			//alert(form_data); 
			var user_type_id = $('#user_type_id').val();
			var email = $('#email').val();
			var name = $('#name').val();
			var gender = $('#gender').val();
			var role_id = $('#role_id').val();
			
			if(user_type_id!='' && email!=='' && name!='' && gender!='' && role_id!='')
			{
				$('#myModal').modal({backdrop: 'static', keyboard: false});
				$.ajax({
					type: "POST",
					url: "ajax_pages/save_user_data.php?action=<?php echo $action; ?>&table=<?php echo $table1; ?>&id=<?php echo $id; ?>",
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
							//alert(result.msg);
							window.location="index.php<?php echo $page_name; ?>&action=<?php echo $action; ?>&id=<?php echo $id; ?>";
						}
						else
						if(result.status==0)
						{
							//alert(result.msg);
							$('#myModal').modal("hide");
						}
					},
					error: function(response) {
						alert(response);
					}
				});
			}
			else if(name=='')
			{
				alert('Please fill Name');
				$('#name').focus();
			}
			else if(email=='')
			{
				alert('Please fill email id');
				$('#email').focus();
			}
			/*else if(gender=='')
			{
				alert('Please fill Gender');
				$('#gender').focus();
			}*/
			else if(role_id=='')
			{
				alert('Please fill Role id');
				$('#role_id').focus();
			}
			else
			{
				alert('Please fill all mandatory fields');
			}
			return false;
		});
		
	});

</script>
<link rel="stylesheet" href="../css/fileupload.css">
	<script src="../js/fileupload.js"></script>
			<div class="col-sm-12 well">
				<h3 class="col-sm-10"><?php echo ucfirst($page); ?> <?php echo $content_lang['16']['content']; ?></h3>
				<?php
				$permission['view_permission']=1;
				if($permission['view_permission']==1){?>
				<div class="col-sm-2 text-right" style="padding:0px;">
					<a href="?page=<?php echo $page; ?>&action=view" class="btn btn-warning">
						<span class='glyphicon glyphicon-list'></span>
						<?php echo $content_lang['30']['content']." ".$content_lang['31']['content']; ?>
					</a>
				</div>
				<?php }?>
				<form method="POST" class="form-horizontal" role="form" id="form" enctype="multipart/form-data">
					<div class="col-sm-12" style="">
						<input type="hidden" name="user_type_id" value="2">
						<div class="form-group col-sm-6">
							<label class="control-label col-sm-4" for="title"><?php echo $content_lang['32']['content']; ?> :</label>
							<div class="col-sm-8">
								<select class='form-control' name="title" id="title">
								<?php $$dtl[0]['title']="selected"; ?>
									<option value=""><?php echo $content_lang['9']['content']; ?></option>
									<option value="Mr" <?php echo $Mr; ?>><?php echo $content_lang['40']['content']; ?></option>
									<option value="Miss" <?php echo $Miss; ?>><?php echo $content_lang['41']['content']; ?></option>
									<option value="Mrs" <?php echo $Mrs; ?>><?php echo $content_lang['42']['content']; ?></option>
								</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="control-label col-sm-4" for="name"><?php echo $content_lang['33']['content']; ?><span style="color:red;">*</span> :</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="name" id="name" value="<?php echo $dtl[0]['name']; ?>" placeholder="">
							</div>
						</div>
						<!--<div class="form-group col-sm-6">
							<label class="control-label col-sm-4" for="login_id">Login Id<span style="color:red;">*</span> :</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" name="login_id" id="login_id" value="<?php echo $dtl[0]['login_id']; ?>" placeholder="">
							</div>
						</div>-->
						<div class="form-group col-sm-6">
							<label class="control-label col-sm-4" for="email"><?php echo $content_lang['34']['content']; ?><span style="color:red;">*</span> :</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" name="email" id="email" value="<?php echo $dtl[0]['email']; ?>" placeholder="">
							</div>
						</div>
						
						<!--<div class="form-group col-sm-6">
							<label class="control-label col-sm-4" for="gender">Gender<span style="color:red;">*</span> :</label>
							<div class="col-sm-8">
								<select class='form-control' name="gender" id="gender">
								<?php $$dtl[0]['gender']="selected"; ?>
									<option value="">Select</option>
									<option value="Male" <?php echo $Male; ?>>Male</option>
									<option value="Female" <?php echo $Female; ?>>Female</option>
									<option value="Third Gender" <?php echo $Third; ?>>Third Gender</option>
								</select>
							</div>
						</div>-->
						<div class="form-group col-sm-6">
							<label class="control-label col-sm-4" for="role_id"><?php echo $content_lang['23']['content']; ?><span style="color:red;">*</span> :</label>
							<div class="col-sm-8">
								<?php
								$detail=$data->getData($con, "a.id, a.name", TBL66." a", "", "");
								$rslt=$detail['detail'];
								?>
								<select name="role_id" class="form-control" id="role_id">
									<option value=""><?php echo $content_lang['9']['content']; ?></option>
									<?php foreach ($rslt as $key => $value): ?>
									<option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $dtl[0]['role_id']) ? "selected = 'selected'" : ""; ?>>
									<?php echo $value['name']; ?>
									</option>                                
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
						
							<label class="control-label col-sm-4" for="organization"><?php echo $content_lang['35']['content']; ?> :</label>
							<div class="col-sm-8">
								<input type="tel" class='form-control' name="organization" value="<?php echo $dtl[0]['organization']; ?>" >
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="control-label col-sm-4" for="location"><?php echo $content_lang['36']['content']; ?> :</label>
							<div class="col-sm-8">
								<input type="tel" class='form-control' name="location" value="<?php echo $dtl[0]['location']; ?>" >
							</div>
						</div>
						
						<div class="form-group col-sm-6" >
							<label class="control-label col-sm-4"><?php echo $content_lang['37']['content']; ?> :</label>
							<div class="col-sm-8 radio">
								<label class="checkbox">
									<input type="checkbox" name="status" id="status_active" value="1" <?php echo $dtl[0]['status']==1?"checked":""; ?> checked > <?php echo $content_lang['38']['content']; ?>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group text-center col-sm-12">
						<button type="submit" class="btn btn-danger" id="btn-submit" name="submit"><?php echo $content_lang['5']['content']; ?></button>
					</div>
					
				</form>
			</div>