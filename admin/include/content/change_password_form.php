<script>
$(document).ready(function(){
	/*Jquery Ajax function to call the PHP page which saves the data of the form*/
	$("#btn-submit").click(function(){
		//alert($("#form-question").serialize());
		if($("#current_password").val()=="")
		{
			alert("<?php echo $content_lang['77']['content']; ?>");
			$("#current_password").focus();
			return false;
		}
		if($("#new_password").val()=="")
		{
			alert("<?php echo $content_lang['78']['content']; ?>");
			$("#new_password").focus();
			return false;
		}
		if($("#new_password").val()!=$("#confirm_new_password").val())
		{
			alert("<?php echo $content_lang['79']['content']; ?>");
			$("#confirm_new_password").focus();
			return false;
		}
		
		$('#myModal').modal({backdrop: 'static', keyboard: false});
		$.ajax({
			type: "POST",
			url: "ajax_pages/change_password.php?action=<?php echo $action; ?>&table=<?php echo $table1; ?>&id=<?php echo $id; ?>",
			data: $("#form").serialize(),
			success: function(response) {
				$('#myModal').modal("hide");
				//alert(response);
				var result=JSON.parse(response);
				if(result.status==1)
				{
					alert(result.msg);
					window.location="index.php?page=<?php echo $page; ?>&logout=true";
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
			<div class="well">
				<h3 class="col-sm-10"><?php echo $content_lang['45']['content']; ?></h3>
				<!--<div class="col-sm-2 text-right">
					<a href="?page=<?php echo $page; ?>&action=view" class="btn btn-warning">
						<span class='glyphicon glyphicon-list'></span>
						VIEW LIST
					</a>
				</div>-->
				<form method="POST" class="form-horizontal" role="form" id="form">
					<div class="form-group">
						<label class="control-label col-sm-4" for="current_password">
						<?php echo $content_lang['70']['content']; ?> :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="current_password" id="current_password" value="<?php echo $current_password; ?>" placeholder="<?php echo $content_lang['71']['content']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="new_password">
						<?php echo $content_lang['18']['content']." ".$content_lang['2']['content']; ?> 
						:</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="new_password" id="new_password" value="<?php echo $new_password; ?>" placeholder="<?php echo $content_lang['72']['content']; ?> ">
							<label><?php echo $content_lang['29']['content']; ?> </label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="confirm_new_password">
						<?php echo $content_lang['17']['content']." ".$content_lang['18']['content']." ".$content_lang['2']['content']; ?> 
						:</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" value="<?php echo $confirm_new_password; ?>" placeholder="<?php echo $content_lang['72']['content']; ?> ">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn btn-danger" id="btn-submit"><?php echo $content_lang['5']['content']; ?></button>
						</div>
					</div>
				</form>
			</div>