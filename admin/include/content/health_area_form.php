<?php
if($action=="edit" && $id)
{
	$stmt = $con->prepare("SELECT a.id, a.name, a.health_zone_id FROM $table1 a WHERE id='$id'") or die($con->error);
	$stmt->execute();
	$stmt->bind_result($id, $name, $health_zone_id);
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
					alert("Please fill health zone name");
					return false;
				}
				$('#myModal').modal({backdrop: 'static', keyboard: false});
				$.ajax({
					type: "POST",
					url: "ajax_pages/save.php?action=<?php echo $action; ?>&table=<?php echo $table1; ?>&id=<?php echo $id; ?>",
					data: $("#form").serialize(),
					success: function(response) {
						//alert(response);
						var result=JSON.parse(response);
						if(result.status==1)
						{
							//alert(result.msg);
							window.location="<?php echo $page_name; ?>&action=<?php echo $action; ?>&id=<?php echo $id; ?>";
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
				<h3 class="col-sm-10">Health Area Form</h3>
				<div class="col-sm-2 text-right">
					<a href="<?php echo $page_name; ?>&action=view" class="btn btn-warning">
						<span class='glyphicon glyphicon-list'></span>
						VIEW LIST
					</a>
				</div>
				<form method="POST" class="form-horizontal" role="form" id="form">
					<input type="hidden" name="data_update_id" value="<?php echo $login_id; ?>">
					<input type="hidden" name="data_update_time" value="<?php echo $time; ?>">
					<!--<div class="form-group">
						<label class="control-label col-sm-4" >Id :</label>
						<div class="col-sm-8">
							<label class="control-label" ><?php echo $id; ?></label>
						</div>
					</div>-->
					<div class="form-group">
						<label class="control-label col-sm-4" for="health_zone_id">Health Area :</label>
						<div class="col-sm-8">
							<select class='form-control' name="health_zone_id">
								<option value="">Select</option>
								<?php
								$$screen_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM ".TBL5." a WHERE a.status=1 ORDER BY a.name") or die($con->error);
								$stmt->execute();
								$stmt->bind_result($health_zone_id, $health_zone_name);
								while ($stmt->fetch())
								{
									if($health_zone_id==$id)
										$selected="selected";
									else
										$selected="";
									$health_zone_selected=$$health_zone_id;
									
									echo "<option value='$health_zone_id' $selected>$health_zone_name</option>";
								}
								$stmt->close();
								?>								
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="name">Name :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" placeholder="Enter Health Area">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn btn-danger" id="btn-submit" name="submit">Submit</button>
						</div>
					</div>
				</form>
			</div>