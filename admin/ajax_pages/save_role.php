<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
require_once("../../class/Action.class");
require_once ("../../class/Data.class");

session_start();

$action=$_GET['action'];
$table=$_GET['table'];
$id=$_GET['id'];
$login=$_SESSION[APPLICATION_ID.'_login'];
$_POST['data_entry_id']=$login['login_id'];
$data=new Data();
$save_data = new Action();
$checkExistRole=$data->getData($con, "a.id", TBL66." a", array("name"=>$_POST['name']), "");
if(isset($checkExistRole) && (count($checkExistRole)>2))
{
	$rslt = array();
	$rslt['status']='1';
	$rslt['msg']='This role already exist.';
	echo json_encode($rslt);
}
else
{
	$_POST=array_filter($_POST);
	$save_data->setData($con, $_POST, $table, array(id=>"Set"));

	if($action=="add")
		$rslt=$save_data->insertData();//For new entry of data to insert
	else
	if($action=="edit")
		$rslt=$save_data->updateData(array(id=>$id));//For old entry of data to update

	echo json_encode($rslt);
}
?>

