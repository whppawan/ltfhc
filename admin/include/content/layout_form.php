<?php
if($action=="edit" && $id)
{
	$stmt = $con->prepare("SELECT a.id, a.name, a.type, a.orientation, a.attribute, a.parent_layout_id, a.screen_id, a.sequence FROM $table1 a WHERE id='$id'") or die($con->error);
	$stmt->execute();
	$stmt->bind_result($id, $name, $type, $orientation, $attribute, $parent_layout_id, $screen_id, $sequence);
	$stmt->fetch();
	$stmt->close();
}

?>	
	<script>
	$(document).ready(function(){
		
		/*Jquery Ajax function to call the PHP page which saves the data of the form*/
		$("#btn-submit").click(function(){
			//alert($("#form").serialize());
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
			//}
			return false;
		});
	});
	
	</script>
			<div class="well">
				<h3 class="col-sm-10">Layout Form</h3>
				<div class="col-sm-2 text-right">
					<a href="<?php echo $page_name; ?>&action=view" class="btn btn-warning">
						<span class='glyphicon glyphicon-list'></span>
						VIEW LIST
					</a>
				</div>
				<form method="POST" class="form-horizontal" role="form" id="form">
					<!--<div class="form-group">
						<label class="control-label col-sm-4" >Layout Id :</label>
						<div class="col-sm-8">
							<label class="control-label" ><?php echo $id; ?></label>
						</div>
					</div>-->
					<div class="form-group">
						<label class="control-label col-sm-4" for="name">Layout Name :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" placeholder="Enter Layout Name">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="type">Layout Type :</label>
						<div class="col-sm-8">
							<?php $$type="selected"; ?>
							<select class='form-control' name="type">
								<option value="">Select</option>
								<option value="linear" <?php echo $linear; ?>>Linear</option>
								<option value="relative" <?php echo $relative; ?>>Relative</option>
								<option value="absolute" <?php echo $absolute; ?>>Absolute</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="type">Layout Orientation :</label>
						<div class="col-sm-8">
							<?php $$orientation="selected"; ?>
							<select class='form-control' name="orientation">
								<option value="">Select</option>
								<option value="vertical" <?php echo $vertical; ?>>Vertical</option>
								<option value="Horizontal" <?php echo $horizontal; ?>>Horizontal</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="attribute">Layout Attribute :</label>
						<div class="col-sm-8">
							<textarea class="form-control" name="attribute" id="attribute"><?php echo $attribute; ?></textarea>
						</div>
					</div>
					<!--<div class="form-group">
						<label class="control-label col-sm-4" for="category_id">Parent Layout :</label>
						<div class="col-sm-8">
							<select class='form-control' name="parent_layout_id">
								<option value="">Select</option>
								<?php
								/*$$parent_layout_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table1 a WHERE a.status=1 ORDER BY a.name") or die($con->error);
								$stmt->execute();
								$stmt->bind_result($parentlayoutid, $parent_layout_name);
								while ($stmt->fetch())
								{
									$parent_selected=$$parentlayoutid;
									
									echo "<option value='$parentlayoutid' $parent_selected>$parent_layout_name</option>";
								}
								$stmt->close();*/
								?>								
							</select>
						</div>
					</div>-->
					<div class="form-group">
						<label class="control-label col-sm-4" for="category_id">Screen :</label>
						<div class="col-sm-8">
							<select class='form-control' name="screen_id">
								<option value="">Select</option>
								<?php
								$$screen_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table2 a WHERE a.status=1 ORDER BY a.name") or die($con->error);
								$stmt->execute();
								$stmt->bind_result($screenid, $screen_name);
								while ($stmt->fetch())
								{
									$screen_selected=$$screenid;
									
									echo "<option value='$screenid' $screen_selected>$screen_name</option>";
								}
								$stmt->close();
								?>								
							</select>
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