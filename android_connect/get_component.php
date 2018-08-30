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

$table1=TBL15;
$table2=TBL16;
$table3=TBL17;

$stmt = $con->prepare("SELECT a.id, a.name, a.sequence FROM $table1 a WHERE a.status=1 ORDER BY a.sequence") or die($con->error);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($screen_id, $screen_name, $screen_sequence);

$screen=array();
$layout=array();
$component=array();

if($stmt->num_rows>0)
{
	$rslt['status'] = "1";
	$rslt['screen']=array();
	$img_url=array();
	
	while($stmt->fetch())
	{
		$screen['id'] = $screen_id?$screen_id:"";
		$screen['name'] = $screen_name?$screen_name:"";
		$screen['sequence'] = $screen_sequence?$screen_sequence:"";
		$screen['layout']=array();

		$stmt1 = $con->prepare("SELECT a.id, a.name, a.type, a.orientation, a.attribute, a.sequence FROM $table2 a WHERE a.screen_id='".$screen['id']."' AND a.status=1 ORDER BY a.sequence") or die($con->error);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($layout_id, $layout_name, $layout_type, $layout_orientation, $layout_attribute, $layout_sequence);
		while($stmt1->fetch())
		{
			$layout['id'] = $layout_id?$layout_id:"";
			$layout['name'] = $layout_name?$layout_name:"";
			$layout['type'] = $layout_type?$layout_type:"";
			$layout['orientation'] = $layout_orientation?$layout_orientation:"";
			$layout['attribute'] = $layout_attribute?$layout_attribute:"";
			$layout['sequence'] = $layout_sequence?$layout_sequence:"";
			$layout['component']=array();
			
			$stmt2 = $con->prepare("SELECT a.id, a.".$name_field.", a.type, a.bg_image, a.image, a.save_value, a.mandatory, a.".$options_field.", a.default_value, a.".$attribute_field.", a.onclick_function, a.onclick_target, a.onclick_target_value_id, a.sequence FROM $table3 a WHERE a.screen_id='".$screen['id']."' AND a.layout_id='".$layout['id']."' AND a.status=1 ORDER BY a.sequence") or die($con->error);
			$stmt2->execute();
			$stmt2->store_result();
			$stmt2->bind_result($component_id, $component_name, $component_type, $component_bg_image, $component_image, $component_save_value, $component_mandatory, $component_options, $component_default_value, $component_attribute, $component_onclick_function, $component_onclick_target, $component_onclick_target_value_id, $component_sequence);
			while($stmt2->fetch())
			{
				$component['id']=$component_id?$component_id:"";
				$component['name']=$component_name?$component_name:"";
				$component['type']=$component_type?$component_type:"";
				$component['image']=APPLICATION_ID.$component_image;
				if($component_image)
					$img_url[]=$component['image'];
				if($component_bg_image!="")
				{
					$component['bg_image']=$component_bg_image;
					$img_url[]=APPLICATION_ID.$component_bg_image;
				}
				else
					$component['bg_image']="";
				//$component['background_image']="131.png";
				$component['save_value']=$component_save_value?$component_save_value:"";
				$component['mandatory']=$component_mandatory?$component_mandatory:"";
				$component['options']=$component_options?$component_options:"";
				$component['default_value']=$component_default_value?$component_default_value:"";
				$component['attribute']=$component_attribute?$component_attribute:"";
				$component['onclick_function']=$component_onclick_function?$component_onclick_function:"0";
				if($component_onclick_target && $component_onclick_target_value_id)
					$component['onclick']="$component_onclick_target | $component_onclick_target_value_id";
				else
					unset($component['onclick']);
				$component['sequence']=$component_sequence?$component_sequence:"";
				
				array_push($layout['component'], $component);
			}
			//print_r($layout);
			array_push($screen['layout'], $layout);
		}
		array_push($rslt['screen'], $screen);
	}
	$rslt['img_url']=$img_url;
}

echo json_encode($rslt);
?>

