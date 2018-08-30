<?php
/*Get layout name & id of the selected screen*/
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
if($_GET['table'])
{
	if($_GET['where_indicator'])
	{
		$table=$_GET['table'];
		$where_indicator=$_GET['where_indicator'];
		$where_value=$_GET['where_value'];
		$target=$_GET['target'];

		$stmt = $con->prepare("SELECT id, name FROM $table WHERE $where_indicator=? AND status=1 ORDER BY name");
		if(!$con->error)
		{
			$stmt->bind_param("s", $where_value);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id, $name);
			if(!$stmt->error)
			{
				echo "<option value=''>Select</option>";
				if($stmt->num_rows>0)
				{
					while ($stmt->fetch())
					{
						echo "<option value='$id'>$name</option>";
					}
				}
			}
			else
				echo "<option value=''>".$stmt->error."</option>";
			$stmt->close();
		}
		else
			echo "<option value=''>".$con->error."</option>";
	}
	else
		echo "<option value=''>".print_r($_GET)."</option>";
}
else
	echo "<option value=''>".print_r($_GET)."</option>";

?>

