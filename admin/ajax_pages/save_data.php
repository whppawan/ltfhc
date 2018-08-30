<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
require_once("../../class/Action.class");
require_once("../../class/AutoSequence.class");
session_start();

$action=$_GET['action'];
$table=$_GET['table'];
$id=$_GET['id'];
$login_id=$_SESSION[APPLICATION_ID.'_login_id'];

/*Creating class AutoSequence's object. It extends Action class*/
$save_data = new AutoSequence();
$where=" status=1";
if($_POST['screen_id'])
	$where .=" AND screen_id='".$_POST['screen_id']."'";
if($_POST['layout_id'])
	$where .=" AND layout_id='".$_POST['layout_id']."'";

if($table=="config_component")
	$_POST['save_value']=$_POST['save_value']!=""?$_POST['save_value']:0;

//print_r($_POST);

$stmt = $con->prepare("SELECT max(sequence) FROM $table WHERE $where") or die($con->error);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($max_sequence);
$stmt->fetch();

if($action=="add")
{
	/*For new entry of data to insert*/
	$_POST['sequence']=($_POST['sequence']<$max_sequence)?$_POST['sequence']:($max_sequence+1);
	$_POST=array_filter($_POST);
	$save_data->setData($con, $_POST, $table, array(id=>"Insert"));
	$rslt=$save_data->insertData();
	$id=$rslt['insert_id'];
}
else
if($action=="edit")
{
	/*For old entry of data to update*/
	$_POST['sequence']=($_POST['sequence']<=$max_sequence)?$_POST['sequence']:($max_sequence+1);
	$_POST=array_filter($_POST);
	$save_data->setData($con, $_POST, $table, array(id=>"Update"));
	$rslt=$save_data->updateData(array(id=>$id));
}

/*Save Image*/
//print_r($_POST);
if($_FILES['image']['tmp_name'])
{
	$saving_path="/images/component/$id".".png";
	$upload_path="../../images/component/$id".".png";
	$save_data->setData($con, array(image=>$saving_path), $table, array(id=>"Insert"));
	$rslt=$save_data->updateData(array(id=>$id));
	move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path);
}

if($_FILES['bg_image']['tmp_name'])
{
	$image_name=$_FILES['bg_image']['name'];
	$saving_path="/images/component/$image_name";
	$upload_path="../../images/component/$image_name";
	$save_data->setData($con, array(bg_image=>$saving_path), $table, array(id=>"Insert"));
	$rslt=$save_data->updateData(array(id=>$id));
	move_uploaded_file($_FILES["bg_image"]["tmp_name"], $upload_path);
}

/*Manage the sequence of the record*/

if($rslt['status']==1 && $_POST['sequence']>0)
{
	$where= " AND a.sequence>='".$_POST['sequence']."' AND a.id!='$id'";
	if($_POST['screen_id'])
		$where .= " AND a.screen_id='".$_POST['screen_id']."'";
	if($_POST['layout_id'])
		$where .= " AND a.layout_id='".$_POST['layout_id']."'";
	
	$rslt=$save_data->sequencingData($_POST['sequence'], $where);
}

echo json_encode($rslt);
?>

