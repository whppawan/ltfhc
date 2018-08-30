<?php
require_once ("../include/config.php");
require_once ("../include/".PAGE6.".php");
require_once ("../class/Data.class");

if($_REQUEST['language']!='')
	$language = $_REQUEST['language'];
else
	$language = "en";

$table1 =TBL69;	
$data=new Data();
$data_language=$data->getData($con, "id, $language as content", "$table1 a", "", "");
$content_lang = $data_language['detail'];

//print_r($content_lang);

$rslt = array("status"=>0, "msg"=>"Email not found");
//print_r($_REQUEST);

if($_REQUEST['email'])
{
	require_once ("../include/config.php");
	$rslt['msg']="<strong>Error!</strong> Mail has not been sent. Please try after sometime.";
	$rslt['status']=0;
	
	$to=$_REQUEST['email'];
	$loginid = explode('@',$_REQUEST['email']);
	$login_id= $loginid[0];
	$_REQUEST['message']="LTFHC Reset password link";
	$email = "Do not reply";
	$subject = "LTFHC Reset password link";
	$txt = "<p>Dear User,</p>
			<p>Click on the following link to change your password in ERCC application.</p>
			<p>".URL.APPLICATION_NAME."?page=reset_password&login_id=$login_id</p>";
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: LTFHC' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

	if(mail($to,$subject,$txt,$headers))
	{
		$rslt['status']=1;
		$rslt['msg']=$content_lang['74']['content'];
	}	
}
echo json_encode($rslt);

?>