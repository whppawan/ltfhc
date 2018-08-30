<?php
require_once ("../class/Data.class");

$data=new Data();
$table =TBL69;	
//print_r($permission);

?>							
	<script>
	$(document).ready(function(){
		
		});
		
		/*Jquery Ajax function to call the PHP page which saves the data of the form*/
function submitForm(id)
{		
	var form_data = $("#form_"+id).serialize();
	//var form_data = $("#form").serialize();
	//alert(form_data);
	$('#myModal').modal({backdrop: 'static', keyboard: false});
		$.ajax({
			type: "POST",
			url: "ajax_pages/save_lang_data.php?action=edit&table=<?php echo $table; ?>&id="+id,
			data: form_data,
			success: function(response) {
				//alert(response);
				var result=JSON.parse(response);
						$('#myModal').modal("hide");
						if(result.status==1)
						{
							//alert(result.msg);
							//window.location="index.php<?php echo $page_name; ?>&action=<?php echo $action; ?>&id="+id;
						}
						else
						if(result.status==0)
						{
							//alert(result.msg);
							//$('#myModal').modal("hide");
						}
					},
					error: function(response) {
						alert(response);
					}
				});
}
</script>
<link rel="stylesheet" href="../css/fileupload.css">
	<script src="../js/fileupload.js"></script>
			<div class="col-sm-12 well">
				<h3 class="col-sm-10"><?php echo ucfirst($page); ?> <?php echo $content_lang['16']['content']; ?></h3>
				<?php
				$permission['view_permission']=1;
				if($permission['view_permission']==1){?>
				<div class="col-sm-2 text-right" style="padding:0px;">
				
				</div>
				<?php }?>
				
				<?php
				$da_language=$data->getData($con, "*", "$table a", array("status"=>"1"), "");
				$cont_lang = $da_language['detail'];
				//print_r($cont_lang);
				for($i=0;$i<sizeof($cont_lang);$i++)
				{
				?>
				<form method="POST" class="form-horizontal" role="form" id="form_<?php echo $cont_lang[$i]['id']; ?>" >
					<div class="col-sm-12" style="border-bottom:1px solid; margin-top:10px; padding-bottom:10px;">
						<div class="col-sm-1">
								<?php echo $cont_lang[$i]['id']; ?>
						</div>
						<div class="col-sm-3">
							<label class="control-label col-sm-4" for="name">English</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="en" id="en_<?php $cont_lang[$i]['id']; ?>"><?php echo $cont_lang[$i]['en']; ?></textarea>
							</div>
						</div>
						
						
						<div class="col-sm-3">
							<label class="control-label col-sm-4" for="name">French</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="fr" id="fr_<?php $cont_lang[$i]['id']; ?>"><?php echo $cont_lang[$i]['fr']; ?></textarea>
							</div>
						</div>
						
						<div class="col-sm-3">
							<label class="control-label col-sm-4" for="name">Swahili</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="sw" id="sw_<?php $cont_lang[$i]['id']; ?>"><?php echo $cont_lang[$i]['sw']; ?></textarea>
							</div>
						</div>
					
						<div class="text-center col-sm-2">
							<button type="button" class="btn btn-danger"  onclick="submitForm('<?php echo $cont_lang[$i]['id']; ?>')" ><?php echo $content_lang['5']['content']; ?></button>
						</div>
					</div>
						
				</form>
			
				<?php } ?>
		</div>