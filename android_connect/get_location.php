<?php
require_once ("../include/config.php");
require_once ("../include/".PAGE6.".php");

//$_POST["ltfhcJSON"]='{"language":"sw"}';
$json = $_POST["ltfhcJSON"];

if (get_magic_quotes_gpc())
	$json = stripslashes($json);
$data = json_decode($json);

$a=array();

$language=$data->language;
if($language=="en")
{
	$name_field="en_name";
	$options_field="en_options";
	$attribute_field="en_attribute";
}
else
if($language=="fr")
{
	$name_field="fr_name";
	$options_field="fr_options";
	$attribute_field="fr_attribute";
}
else
if($language=="sw")
{
	$name_field="sw_name";
	$options_field="sw_options";
	$attribute_field="sw_attribute";
}
else
{
	$name_field="en_name";
	$options_field="en_options";
	$attribute_field="en_attribute";
}

$table1=TBL5;
$table2=TBL6;

$stmt = $con->prepare("SELECT a.id, a.name FROM $table1 a WHERE a.status=1") or die($con->error);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($health_zone_id, $health_zone_name);

$health_zone=array();
$health_area=array();

if($stmt->num_rows>0)
{
	$rslt['status'] = "1";
	$rslt['health_zone']=array();
	$img_url=array();
	
	while($stmt->fetch())
	{
		$health_zone['id'] = $health_zone_id?$health_zone_id:"";
		$health_zone['name'] = $health_zone_name?$health_zone_name:"";
		$health_zone['health_area']=array();

		$stmt1 = $con->prepare("SELECT a.id, a.name FROM $table2 a WHERE a.health_zone_id='".$health_zone['id']."' AND a.status=1") or die($con->error);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($health_area_id, $health_area_name);
		while($stmt1->fetch())
		{
			$health_area['id'] = $health_area_id?$health_area_id:"";
			$health_area['name'] = $health_area_name?$health_area_name:"";
			
			//print_r($health_area);
			array_push($health_zone['health_area'], $health_area);
		}
		array_push($rslt['health_zone'], $health_zone);
	}
}

echo json_encode($rslt);
?>

