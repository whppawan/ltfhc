<?php
$action=$_REQUEST['action'];
$table1=TBL5;
$table2=TBL6;
$id=$_GET['id'];
$start=$_GET['start'];
$msg=$_GET['msg'];

if($action=='add'|| $action=='edit')
 $sub_page="form";
else
 $sub_page="list";
include_once("include/content/".$page."_".$sub_page.".php");
?>