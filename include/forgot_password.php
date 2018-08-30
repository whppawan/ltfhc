<?php
require_once ("include/config.php");
require_once ("include/".PAGE6.".php");
require_once ("class/Data.class");

if($_REQUEST['language']!='')
	$language = $_REQUEST['language'];
else
	$language = "en";

$table1 =TBL69;	
$data=new Data();
$data_language=$data->getData($con, "id, $language as content", "$table1 a", "", "");
$content_lang = $data_language['detail'];

//print_r($content_lang);
?>
<div class=" col-sm-offset-4 col-sm-4 text-left" style="margin-top:100px;">
	<div class="well">
		<h2><?php echo $content_lang['73']['content']; ?></h2><br>
		<!--<div class="alert alert-danger"></div>-->
		<form role="form" method="POST" id="form_forgot_password" action="" >
			<div class="form-group">
				<input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $content_lang['76']['content']; ?>" autocomplete="off" >
			</div>
			<a style="margin:5px; float:right;" href="index.php?page=login_form&language=<?php echo $language; ?>" ><?php echo $content_lang['0']['content']; ?></a>	
			<br>		
			<button type="button" class="btn btn-danger" id="btn_forgot_password" onclick="submitForm('form_forgot_password', 'ajax_pages/mail.php?language=<?php echo $language; ?>', '', 'div_mail_response');" ><?php echo $content_lang['5']['content']; ?></button>
			<div class="loader"></div>
		</form>
		<br>
		<div class="" id="div_mail_response" style="color:green; display:none;" >
			<b><?php echo $content_lang['74']['content']; ?></b>
			<br>
			<a style="margin:5px; float:right;" href="index.php?page=login_form&language=<?php echo $language; ?>" ><?php echo $content_lang['0']['content']; ?></a>	
			<br>
		</div>
		<div class="" id="div_mail_response1" style="color:red; display:none;" >
			<b><?php echo $content_lang['75']['content']; ?></b>
			<br>
			<a style="margin:5px; float:right;" href="index.php?page=login_form&language=<?php echo $language; ?>" ><?php echo $content_lang['0']['content']; ?></a>	
			<br>
		</div>
	</div>
</div>
	





