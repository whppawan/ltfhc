<?php
require_once ("../include/config.php");
require_once ("../include/".PAGE6.".php");
require_once("../class/Data.class");
require_once("../class/Password.class");
require_once("../class/Action.class");

session_start();
$login_id=$_GET['login_id'];
$table=$_GET['table'];
$new_password=$_POST['new_password'];

if(!preg_match( '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@#!%*?&])[A-Za-z\d$@#!%*?&]{8,15}/', $new_password) || strlen($new_password) < 8)
	$rslt=array("status"=>0, "msg"=>"Please enter at least 8 characters with uppercase,lowercase letters and valid symbols");
else
{
	$password=new Password($con, $table);
	$rslt=$password->changePassword($new_password, $login_id);
}
echo json_encode($rslt);
?>

