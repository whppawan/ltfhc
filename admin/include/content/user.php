<?php
session_start();
$login=$_SESSION[APPLICATION_ID.'_login'];
//echo "<pre>";
//print_r($login);
$permissionRole = $login['permission']; 

$action=$_REQUEST['action'];
$table1=TBL1;
$user_type_id=1;
$status=1;
$id=$_GET['id'];
$start=$_GET['start'];
$msg=$_GET['msg'];

require_once ("../class/Data.class");
$data=new Data();

$page=PAGE11;
$page_name="?page=$page";

if($action=$_REQUEST['action'])
	$page_name .="&action=$action";
if($id=$_REQUEST['id'])
	$page_name .="&id=$id";

if($msg=$_REQUEST['msg'])
	$page_name .="&msg=$msg";
if($start=$_REQUEST['start'])
	$page_name .="&start=$start";
if($filter_user_type_id=$_REQUEST['filter_user_type_id'])
{
	//$where .=" AND a.user_type_id='$filter_user_type_id'";
	$where =array('a.user_type_id'=>$filter_user_type_id);
	$page_name .="&filter_user_type_id=$filter_user_type_id";
}
if($action=='add'|| $action=='edit')
 $sub_page="form";
else
 $sub_page="list";
	
	$permissionRole = $login['permission'];
        $permission = 0;

        foreach ($permissionRole as $key => $value) {
            if ($value["module_id"] == 3) {
               $permission = $value;
           }
        }

include_once("include/content/".$page."_".$sub_page.".php");
?>