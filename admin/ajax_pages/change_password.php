<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
require_once("../../class/Data.class");
require_once("../../class/Password.class");
require_once("../../class/Action.class");

session_start();
$login=$_SESSION[APPLICATION_ID.'_login'];
$login_id=$login['login_id'];

if($login['language']!='')
	$language_code = $login['language'];
else
	$language_code = "en";
$data=new Data();
$data_language=$data->getData($con, "id, $language_code as content", TBL69." a", "", "");
$content_lang = $data_language['detail'];

$table=$_GET['table'];
$new_password=$_POST['new_password'];

if(!preg_match( '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@#!%*?&])[A-Za-z\d$@#!%*?&]{8,15}/', $new_password) || strlen($new_password) < 8)
	$rslt=array("status"=>0, "msg"=>$content_lang['81']['content']);
else
{
	$current_password=$_POST['current_password'];
	$password=new Password($con, $table);
	$rslt=$password->changePasswordWithMatchCurrent($current_password, $new_password, $login_id);
}
if($rslt['msg']=="Your current password is incorrect")
	$rslt['msg']=$content_lang['80']['content'];
else
if($rslt['msg']=="Password has been changed")
	$rslt['msg']=$content_lang['82']['content'];

echo json_encode($rslt);
?>

