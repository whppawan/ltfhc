<?php
$table1=TBL1;
$login_id=$_GET['login_id'];
?>
<script>
$(document).ready(function(){
	/*Jquery Ajax function to call the PHP page which saves the data of the form*/
	$("#btn-submit").click(function(){
		//alert($("#form-question").serialize());
		if($("#current_password").val()=="")
		{
			alert("Please fill current password");
			$("#current_password").focus();
			return false;
		}
		if($("#new_password").val()=="")
		{
			alert("Please fill  new password");
			$("#new_password").focus();
			return false;
		}
		if($("#new_password").val()!=$("#confirm_new_password").val())
		{
			alert("New password and confirm password are not matching");
			$("#confirm_new_password").focus();
			return false;
		}
		
		$('#myModal').modal({backdrop: 'static', keyboard: false});
		$.ajax({
			type: "POST",
			url: "ajax_pages/change_password.php?login_id=<?php echo $login_id; ?>&table=<?php echo $table1; ?>",
			data: $("#form").serialize(),
			success: function(response) {
				$('#myModal').modal("hide");
				//alert(response);
				var result=JSON.parse(response);
				if(result.status==1)
				{
					alert(result.msg+" Now you can logged in with new password");
					window.location="index.php?&logout=true";
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

<div class=" col-sm-offset-4 col-sm-4 text-left"  style="margin-top:100px;">
	<div class="well">
		<h2>Reset Password</h2>
		<!--<div class="alert alert-danger"></div>-->
		<form role="form" id="form">
			<div class="form-group">
				<input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter new password">
				<label>Password should contain minimum 8 characters with combination of alphabets(A to Z AND a to z), numbers(0 to 9) and special charectors(@!#()$&)</label>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" id="confirm_new_password" placeholder="Re-enter password">
			</div>			
			<button class="btn btn-danger" id="btn-submit">Submit</button>
			<div class="loader"></div>
		</form>
	</div>
</div>