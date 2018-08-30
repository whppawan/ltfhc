<?php

$action=$_REQUEST['action'];
$table1=TBL16;
$table2=TBL15;
$id=$_GET['id'];
$start=$_GET['start'];
$msg=$_GET['msg'];

$page=PAGE9;
$page_name="?page=$page";

if($search_screen_id=$_REQUEST['search_screen_id'])
{
	$where .=" AND a.screen_id='$search_screen_id'";
	$layout_where .=" AND a.screen_id='$search_screen_id'";
	$page_name .="&search_screen_id=$search_screen_id";
}
$page_name .="&start=".$_REQUEST['start'];

if($action=='add'|| $action=='edit')
 $sub_page="form";
else
 $sub_page="list";

/*Its include the layout form/list page according the selection*/
include_once("include/content/".$page."_".$sub_page.".php");
?>