<?php
/*Get detail of the perticular record*/
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
if($_POST['id'])
{
	$id=$_POST['id'];
	$table1=$_POST['table1'];
	$table2=$_POST['table2'];
	$table3=$_POST['table3'];
	
	$stmt = $con->prepare("SELECT a.id, a.en_name, a.fr_name, a.sw_name, a.type, a.save_value, a.mandatory, a.en_options, a.fr_options, a.sw_options, a.default_value, a.en_attribute, a.fr_attribute, a.sw_attribute, a.onclick_function, a.onclick_target, d.name, b.name, c.name, a.sequence, a.status FROM $table1 a LEFT JOIN $table2 b ON a.layout_id=b.id AND b.status=1 LEFT JOIN $table3 c ON a.screen_id=c.id LEFT JOIN $table3 d ON a.onclick_target_value_id=d.id AND c.status=1 WHERE a.id=?");
	if(!$con->error)
	{
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id, $en_name, $fr_name, $sw_name, $type, $save_value, $mandatory, $en_options, $fr_options, $sw_options, $default_value, $en_attribute, $fr_attribute, $sw_attribute, $onclick_function, $onclick_target, $onclick_target_value, $layout_name, $screen_name, $sequence, $status);
		if(!$stmt->error)
		{
			if($stmt->num_rows>0)
			{
				$stmt->fetch();
				?>
				<div class="col-sm-12">
					<div class="col-sm-5">Component ID</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $id; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Name</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $en_name; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Type</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $type; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Save Value</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $save_value; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Mandatory</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $mandatory; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Options</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $en_options; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Default Value</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $default_value; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Attribute</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $en_attribute; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Onclick Function</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $onclick_function; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Onclick Target</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $onclick_target; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Onclick Target Value</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $onclick_target_value; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Layout Name</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $layout_name; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Screen Name</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $screen_name; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Sequence</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $sequence; ?></div>
				</div><br>&nbsp;
				<div class="col-sm-12">
					<div class="col-sm-5">Active Status</div>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6"><?php echo $status; ?></div>
				</div><br>&nbsp;
				<?php
			}
		}
		else
			echo "<option value=''>".$con->error."</option>";
		$stmt->close();
	}
	else
		echo "<option value=''>".$stmt->error."</option>";
}
else
{
	echo "<option value=''>"; print_r($_POST); echo"</option>";
}
?>

