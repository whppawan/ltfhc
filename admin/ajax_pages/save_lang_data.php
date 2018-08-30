<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
require_once("../../class/Action.class");
session_start();

$action=$_GET['action'];
$table=$_GET['table'];
$id=$_GET['id'];
$login_id=$_SESSION[APPLICATION_ID.'_login_id'];
$save_data= new Action();
//print_r($_POST);
if($action=="add")
{
	/*For new entry of data to insert*/
	$_POST=array_filter($_POST);
	$save_data->setData($con, $_POST, $table, array(id=>"Insert"));
	$rslt=$save_data->insertData();
}
else
if($action=="edit")
{
	/*For old entry of data to update*/
	$_POST=array_filter($_POST);
	$save_data->setData($con, $_POST, $table, array(id=>"Update"));
	$rslt=$save_data->updateData(array(id=>$id));
}
echo json_encode($rslt);
?>

