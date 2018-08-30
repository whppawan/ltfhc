<?php
/*Get layout name & id of the selected screen*/
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
if($_POST['table'])
{
	if($_POST['screen_id'])
	{
		$table=$_POST['table'];
		$screen_id=$_POST['screen_id'];
		$stmt = $con->prepare("SELECT a.id, a.name FROM $table a WHERE a.screen_id=? AND a.status=1 ORDER BY a.sequence");
		if(!$con->error)
		{
			$stmt->bind_param("s", $screen_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($layoutid, $layout_name);
			if(!$stmt->error)
			{
				if($stmt->num_rows>0)
				{
					echo "<option value=''>Select layout</option>";
					while ($stmt->fetch())
					{
						echo "<option value='$layoutid'>$layout_name</option>";
					}
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
}
else
{
	echo "<option value=''>"; print_r($_POST); echo"</option>";
}
?>

