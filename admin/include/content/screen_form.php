<?php
if($action=="edit" && $id)
{
	$stmt = $con->prepare("SELECT a.id, a.name, a.sequence FROM $table1 a WHERE id='$id'") or die($con->error);
	$stmt->execute();
	$stmt->bind_result($id, $name, $sequence);
	$stmt->fetch();
	$stmt->close();
}

?>	
	<script>
	$(document).ready(function(){
		
		/*Jquery Ajax function to call the PHP page which saves the data of the form*/
		$("#btn-submit").click(function(){
			//alert($("#form-question").serialize());
			//if(trimester)
			//{
				if($("#name").val()=="")
				{
					alert("Please fill category name");
					return false;
				}
				$('#myModal').modal({backdrop: 'static', keyboard: false});
				$.ajax({
					type: "POST",
					url: "ajax_pages/save_data.php?action=<?php echo $action; ?>&table=<?php echo $table1; ?>&id=<?php echo $id; ?>",
					data: $("#form").serialize(),
					success: function(response) {
						//alert(response);
						var result=JSON.parse(response);
						if(result.status==1)
						{
							//alert(result.msg);
							window.location="index.php?page=<?php echo $page; ?>&action=<?php echo $action; ?>&id=<?php echo $id; ?>";
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
			//}
			return false;
		});
	});
	
	</script>
			<div class="well">
				<h3 class="col-sm-10">Screen Form</h3>
				<div class="col-sm-2 text-right">
					<a href="?page=<?php echo $page; ?>&action=view" class="btn btn-warning">
						<span class='glyphicon glyphicon-list'></span>
						VIEW LIST
					</a>
				</div>
				<form method="POST" class="form-horizontal" role="form" id="form">
					<!--<div class="form-group">
						<label class="control-label col-sm-4" >Screen Id :</label>
						<div class="col-sm-8">
							<label class="control-label" ><?php echo $id; ?></label>
						</div>
					</div>-->
					<div class="form-group">
						<label class="control-label col-sm-4" for="name">Screen Name :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" placeholder="Enter Screen Name">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="sequence">Sequence :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="sequence" id="sequence" value="<?php echo $sequence; ?>" placeholder="Enter Sequence">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn btn-danger" id="btn-submit" name="submit">Submit</button>
						</div>
					</div>
				</form>
			</div>