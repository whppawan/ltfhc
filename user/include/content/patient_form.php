<?php
$stmt = $con->stmt_init();
$stmt = $con->prepare("SELECT a.id, a.question, a.suggestiontext, b.categoryname, a.field_type, a.field_option, a.default_value, a.field_display, a.field_attribute, a.custom_js FROM ".TBL5." a JOIN ".TBL4." b ON a.categoryid=b.id AND b.status=1 WHERE a.tremesterid = '".$patient_detail['trimester']."' AND a.status=1 ORDER BY a.categoryid, a.sequenceid") or die($con->error);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $question, $suggestiontext, $categoryname, $field_type, $field_option, $default_value, $field_display, $field_attribute, $custom_js);

/*if (extension_loaded('mysqlnd'))
        echo 'extension mysqlnd is loaded'; // WORKED

    if (extension_loaded('mysqli'))
        echo 'extension mysqli is loaded'; // WORKED*/
?>
	<script>
	$(document).ready(function(){
	
		$("#btn-submit").click(function(){
			if(validation()==true)
			{
				$('#myModal').modal({backdrop: 'static', keyboard: false});
				$.ajax({
					type: "POST",
					url: "ajax_pages/submit_patient_detail.php",
					data: $("#form-patient").serialize(),
					success: function(response) {
						var result=JSON.parse(response);
						if(result.status==1)
						{
							alert(result.msg);
							window.location="index.php";
						}
						else
						if(result.status==0)
							alert(result.msg);
						else
							alert(response);
							
					},
					error: function(response) {
						alert(response);
					}
				});
			}
			return false;
		});
	});
	
	function toggle(value, showvalue, hidevalue, show_target, hide_target)
	{
		//alert("hi");
		if(show_target)
			var show_target=show_target.split(/[|]/);
		if(hide_target)
			var hide_target=hide_target.split(/[|]/);
	 
		if(showvalue.indexOf(value) >= 0)
		{
			if(show_target)
			{
				for (var i = 0; i < show_target.length; i++)
				{
					$("#"+show_target[i]).slideDown();
					$("#hr_"+show_target[i]).show();
				}
			}
			if(hide_target)
			{
				for (var i = 0; i < hide_target.length; i++)
				{
					$("#"+hide_target[i]).slideUp();
					$("#ans_"+hide_target[i]).prop("selectedIndex", 0);
					$("#hr_"+hide_target[i]).hide();
				}
			}
		}
		else
		if(hidevalue.indexOf(value) >= 0)
		{
			if(show_target)
			{
				for (var i = 0; i < show_target.length; i++)
				{
					$("#"+show_target[i]).slideUp();
					$("#ans_"+show_target[i]).prop("selectedIndex", 0);
					$("#hr_"+show_target[i]).hide();
				}
			}
			if(hide_target)
			{
				for (var i = 0; i < hide_target.length; i++)
				{
					$("#"+hide_target[i]).slideDown();
					$("#hr_"+hide_target[i]).show();
				}
			}
		}
	}
	</script>		<div class="well">
				<h3><?php echo $patient_detail['page_heading']; ?></h3>
				<?php
				if($patient_detail['last_entry_info'])
					echo"<h4 class='alert alert-warning'>
							<span class='glyphicon glyphicon-info-sign'></span>
							".$patient_detail['last_entry_info']."
						</h4><hr>";
				?>
				<form class="form-horizontal" role="form" id="form-patient">
					<?php
					while ($stmt->fetch())
					{
						/*********************Perticular Code : Start************************/
						if($patient_detail['trimester']=="3-2" && $id==31)
							$field_display="none";
						if($patient_detail['trimester']=="3-2" && $id==167)
							$field_display="";
						/*********************Perticular Code : End************************/

						$field_option=explode("|", $field_option);
						
						if($cat!=$categoryname)
							echo"<h4 class='alert alert-info'><strong>".ucfirst($categoryname)."</strong></h4><hr>";
						$cat=$categoryname;
						echo"	<div class='form-group' id='$id' style='display:$field_display'>
									<label class='control-label col-sm-5' for='ans_$id'>$question :</label>								
									<div class='col-sm-4'>";
						switch ($field_type)
						{
							case "text":
							$text_val=$patient_detail['indctr_'.$id] ? $patient_detail['indctr_'.$id] : $default_value;
							echo"<input type='text' class='form-control' id='ans_$id' name='ans_$id"."[]' value='$text_val' $field_attribute >";
							break;
							
							case "datetime": 
							echo"<div class='input-group date' id='datetimepicker_".$id."'>
							<input type='text' class='form-control' id='ans_$id' name='ans_$id"."[]' value='".$patient_detail['indctr_'.$id]."' readonly  $field_attribute >
									<span class='input-group-addon'>
										<span class='glyphicon glyphicon-calendar'></span>
									</span>
									</div>
									<script type='text/javascript'>
									$(function () {
										$('#datetimepicker_".$id."').datetimepicker({
											format: 'YYYY-MM-DD LT',
											ignoreReadonly: true
										});
									});
									</script>";
							break;
							
							case "date": 
							echo"<div class='input-group date' id='datetimepicker_".$id."'>
							<input type='text' class='form-control' id='ans_$id' name='ans_$id"."[]' value='".$patient_detail['indctr_'.$id]."' readonly  $field_attribute >
									<span class='input-group-addon'>
										<span class='glyphicon glyphicon-calendar'></span>
									</span>
									</div>
									<script type='text/javascript'>
									$(function () {
										$('#datetimepicker_".$id."').datetimepicker({
											format: 'YYYY-MM-DD',
											ignoreReadonly: true
										});
									});
									</script>";
							break;
							
							case "time": 
							echo"<div class='input-group date' id='datetimepicker_".$id."'>
							<input type='text' class='form-control' id='ans_$id' name='ans_$id"."[]' value='".$patient_detail['indctr_'.$id]."' readonly  $field_attribute >
									<span class='input-group-addon'>
										<span class='glyphicon glyphicon-calendar'></span>
									</span>
									</div>
									<script type='text/javascript'>
									$(function () {
										$('#datetimepicker_".$id."').datetimepicker({
											format: 'LT',
											ignoreReadonly: true
										});
									});
									</script>";
							break;

							case "radio":
							for($i=0; $i<sizeof($field_option); $i++)
							{
								if($default_value==$field_option[$i])
									$checked="checked";
								else
									$checked="";
								echo "	<input type=radio name='ans_$id"."[]' id='ans_$id"."_$i' value='$field_option[$i]' $checked $field_attribute > $field_option[$i]&nbsp;&nbsp;&nbsp;&nbsp";
							}
							break;
							
							case "select":
							echo"	<select class='form-control' name='ans_$id"."[]' id='ans_$id' $field_attribute >
										<option value=''>Select</option>";
							for($i=0; $i<sizeof($field_option); $i++)
							{
								if($default_value==$field_option[$i])
									$selected="selected";
								else
									$selected="";
								echo"	<option value='$field_option[$i]' title='$field_option[$i]' $selected>$field_option[$i]</option>";
							}
							echo"	</select>";
							break;
						}
						echo"			</div>
									<label class='col-sm-3' for='ans_$id' id='suggestion_$id'>$suggestiontext</label>
								</div>
								$custom_js
								<hr id='hr_$id' style='display:$field_display'>";
						$validation[] = "
							if($('#ans_$id').val()=='' && $('#$id').css('display')!='none')
							{
								alert('Please give the ans of question : $question');
								$('#ans_$id').focus();
								return false;
							}
						";
					}
					$stmt->free_result();
					$stmt->close();
					echo"<h4 class='alert alert-warning'><strong>Instructions:-</strong> ".$patient_detail['instruction']."</h4><hr>";
					?>
					<script>
					function validation()
					{
						<?php 
						foreach($validation as $validation)
						{
							echo $validation;
						}
						?>
						return true;
					}
					</script>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-4">
							<button type="submit" class="btn btn-danger" id="btn-submit">Submit</button>
						</div>
					</div>
				</form>
			</div>