<?php
require_once ("../class/Data.class");
$data=new Data();

if($action=="edit" && $id)
{
	$detail=$data->getData($con, "a.id, a.name, a.status", "$table1 a", array("id"=>$id), "");
	$dtl=$detail['detail'];
	
}
?>							
	
			<div class="well">
				<h3 class="col-sm-10" style="padding:0px;" ><?php echo ucfirst($page); ?> Form</h3>
				<div class="col-sm-2 text-right" style="padding:0px;">
					<a href="?page=<?php echo $page ?>&action=view" class="btn btn-warning">
						<span class='glyphicon glyphicon-list'></span>
						VIEW LIST
					</a>
				</div>
				<form method="POST" class="form-horizontal" role="form" id="form" enctype="multipart/form-data">
					
					
					
					<div class="form-group">
						<label class="control-label col-sm-4" for="option">Role :</label>
						<div class="col-sm-8">
							<input type="text" class='form-control' name="name" id="name" value="<?php echo $dtl[0]['name']; ?>" >
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn btn-danger" id="btn-submit">Submit</button>
						</div>
					</div>
				</form>
			</div>
			<script>
	$(document).ready(function(){
		
		/*Jquery Ajax function to call the PHP page which saves the data of the form*/
		$("form#form").submit(function(){
			var form_data = new FormData(this);                   
			
				$('#myModal').modal({backdrop: 'static', keyboard: false});
				$.ajax({
					type: "POST",
					url: "ajax_pages/save_role.php?action=<?php echo $action; ?>&table=<?php echo $table1; ?>&id=<?php echo $id; ?>",
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