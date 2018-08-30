<script text="text/javascript">
$(document).ready(function(){
	$('#total').html('<?php echo $content_lang['26']['content']; ?>');
});
</script>

<?php
$page_name="?page=$page";
require_once ("../class/Data.class");

$monthyear = date("Y-n"); 


require_once("../class/Action.class");
$data=new Data();
$save_data= new Action();
$where=array();

if($_POST['filter'])
{
	if($_POST['health_zone']!='' && $_POST['health_area']=='')
	{
		$health_zone=preg_replace('~[\r\n]+~', '', $_POST['health_zone']);
		//$health_zone=mysqli_real_escape_string($con, $health_zone);
		$search1="AND component_id=189 AND TRIM(BOTH '\n' FROM component_value)='".mysqli_real_escape_string($con, $health_zone)."'"; 
	}
	if($_POST['health_area']!='' && $_POST['health_zone']=='')
	{	
		$health_area=preg_replace('~[\r\n]+~', '', $_POST['health_area']);
		//$search2="AND component_id=133 AND component_value='".$_POST['health_area']."'";
		$search2="AND component_id=133 AND TRIM(BOTH '\n' FROM component_value)='".mysqli_real_escape_string($con, $health_area)."'"; 
	}
	if($_POST['year']!='')
	{	
		$search3="AND YEAR(visit_time)='".$_POST['year']."'";
	}
	if($_POST['month']!='')
	{	
		$search4="AND MONTH(visit_time)='".$_POST['month']."'";
	}
	//echo "SELECT patient_id FROM ".TBL18." WHERE language_code='$language_code' $search1 $search2 $search3 $search4 $search5";
	
	$result=$con->query("SELECT patient_id FROM ".TBL18." WHERE 1 $search1 $search2 $search3 $search4 $search5") OR die($con->error);
	while($row=$result->fetch_array())
	{
		$merge_array[]=$row['patient_id'];
	}
	
	if($_POST['health_zone']!='' && $_POST['health_area']!='')
	{
		$health_zone=preg_replace('~[\r\n]+~', '', $_POST['health_zone']);
		$health_area=preg_replace('~[\r\n]+~', '', $_POST['health_area']);
		//$search5="AND ((component_id=133 AND TRIM(BOTH '\n' FROM component_value)='".mysqli_real_escape_string($con, $health_area)."') OR (component_id=189 AND TRIM(BOTH '\n' FROM component_value)='".mysqli_real_escape_string($con, $health_zone)."'))"; 
		
		$result=$con->query("SELECT patient_id FROM ".TBL18." WHERE component_id=189 AND TRIM(BOTH '\n' FROM component_value)='".mysqli_real_escape_string($con, $health_zone)."' $search3 $search4") OR die($con->error);
		while($row=$result->fetch_array())
		{
			$merge_array1[]=$row['patient_id'];
		}
	
		$result=$con->query("SELECT patient_id FROM ".TBL18." WHERE component_id=133 AND TRIM(BOTH '\n' FROM component_value)='".mysqli_real_escape_string($con, $health_area)."' $search3 $search4") OR die($con->error);
		while($row=$result->fetch_array())
		{
			$merge_array2[]=$row['patient_id'];
		}
		if(isset($merge_array1) && isset($merge_array2))
		$merge_array= array_intersect($merge_array1,$merge_array2);
	}
	if(count($merge_array)>0)	
	$where_patient_id=array_unique($merge_array);
	else
	$where_patient_id=array();

	//print_r($where_patient_id);
}
else
{
	$result=$con->query("SELECT DISTINCT(patient_id) AS patient_id FROM ".TBL18."") OR die($con->error);
	while($row=$result->fetch_array())
	{
		$where_patient_id[]=$row['patient_id'];
	}
}

/*echo "<table class='table-bordered'>";
echo "	<tr>";
echo "	<td>Patient_id</td>";
$ids="'183','177','7','141','23','189','133','13','208','214','220','225','231','487','237','161','243','542','249','255','260','551','266','357','272','278','341','26','363','367','343','344','423','345','346','347','494','348','500','349','429','382','350','529','532','385','351','392','533','352','530','531','398','399'";
$query1="SELECT id, en_name FROM ".TBL17." WHERE id IN($ids)";
$result1=$con->query($query1) or die($con->error);
while($row1=$result1->fetch_array())
{
	echo"	<td>".$row1['en_name']."</td>";
}
echo "	</tr>";
$query="SELECT DISTINCT(patient_id) AS patient_id FROM ".TBL18;
$result=$con->query($query);
while($row=$result->fetch_array())
{
	echo "<tr>";
	echo"	<td>".$row['patient_id']."</td>";
	$id_array=explode(",", str_replace("'", "", $ids));
	$rslt_array=array();
	$query2="SELECT component_id, component_name FROM ".TBL18." WHERE component_id IN($ids) AND patient_id='".$row['patient_id']."'";
	$result2=$con->query($query2) or die($con->error);
	while($row2=$result2->fetch_assoc())
	{
		array_push($rslt_array, $row2);
	}
	//print_r($rslt_array);
	//echo "<br><br><br>";
	foreach($id_array AS $id)
	{
		echo"<td>";
		//echo $id;
		foreach($rslt_array AS $rslt)
		{
			//print_r($rslt);
			//echo "<br>";
			if($id==$rslt[component_id])
				echo $rslt[component_name];
		}
		echo"</td>";
	}
	echo "</tr>";
}
echo "</table>";*/
?>
<script type="text/javascript">
function validation()
{
	var month = $('#month').val();
	var year = $('#year').val();
	//alert(month);
	if(month!='' && year=='')
	{
		alert('Please select year!');
	}
}
</script>
<div>
	<h3 class="col-sm-10"><?php echo $content_lang['7']['content']; ?></h3>
	<div>
		<table class="table">
			<form method="POST" name="filter_form">
			<tr class='active table-bordered'>
				<td>
					<select class='form-control' name="department">
						<option value=""><?php echo $content_lang['9']['content']." ".$content_lang['10']['content']; ?> </option>
						<?php
						if($_POST['department']=='Prenatal Department')
							$dep_selected = "selected";
						else 
							$dep_selected = "";
							?>
						<option value="Prenatal Department" <?php echo $dep_selected; ?>><?php echo $content_lang['46']['content']; ?></option>
					</select>
				</td>
				<td>
					<select class='form-control' name="health_zone">
						<option value=""><?php echo $content_lang['9']['content']." ".$content_lang['11']['content']; ?></option>
						<?php
						$detail=$data->getData($con, "DISTINCT(a.component_value) AS component_value", TBL18." a", array("a.component_id"=>189), "ORDER BY a.component_value");
						if($detail['status']==1)
						{
							$rslt=$detail['detail'];
							for($i=0; $i<sizeof($rslt); $i++)
							{
								$component_value=trim($rslt[$i]['component_value']);
								//$component_value=preg_replace('~[\r\n]+~', '', $rslt[$i]['component_value']);
								//$component_value=mysqli_real_escape_string($con, $component_value);
								if($component_value==$health_zone)
									{
										$hzone_selected = "selected";
									}
									else 
									{
										$hzone_selected = "";
									}
								if($component_value!=''){
								echo '<option value="'.$component_value.'" '.$hzone_selected.' >'.$component_value.'</option>';
								}
							}
						}
						else
							//echo "<option value=''></option>";
						?>
					</select>
				</td>
				<td>
					<select class='form-control' name="health_area">
						<option value=""><?php echo $content_lang['9']['content']." ".$content_lang['12']['content']; ?></option>
						<?php
						$detail=$data->getData($con, "TRIM(a.component_value) as component_value", TBL18." a", array("component_id"=>133), "GROUP BY TRIM(a.component_value) ORDER BY a.component_value");
						if($detail['status']==1)
						{
							$rslt=$detail['detail'];
							for($i=0; $i<sizeof($rslt); $i++)
							{
								$component_value1=trim($rslt[$i]['component_value']);
								if($component_value1==$_POST['health_area'])
									{
										$harea_selected = "selected";
									}
									else 
									{
										$harea_selected = "";
									}
								if($component_value1!=''){
								echo "<option value='$component_value1' $harea_selected >$component_value1</option>";
								}
							}
						}
						else
							//echo "<option value=''></option>";
						?>
					</select>
				</td>
				<td>
					<select id="year" class='form-control' name="year" >
						<option value=""><?php echo $content_lang['9']['content']." ".$content_lang['13']['content']; ?></option>
						<?php
						$detail=$data->getData($con, "YEAR(visit_time) as year", TBL18, '', "GROUP BY YEAR(visit_time) ORDER BY YEAR(visit_time)");
						if($detail['status']==1)
						{
							$rslt=$detail['detail'];
							for($i=0; $i<sizeof($rslt); $i++)
							{
								
								$year=$rslt[$i]['year'];
								if($year==$_POST['year'])
									{
										$year_selected = "selected";
									}
									else 
									{
										$year_selected = "";
									}
								if($year!='0')
								{
								echo "<option value='$year' $year_selected >$year</option>";
								}
							}
						}
						else
							echo "<option value=''>".$detail['msg']."</option>";
						?>
					</select>
				</td>
				<td>
				<?php
				//echo "<pre>";
				//print_r($_SESSION);
				//echo $login['language'];
				
				if($login['language']=='en')
				{
					$arr_months = array("1"=>"January", "2"=>"February", "3"=>"March", "4"=>"April", "5"=>"May", "6"=>"June", "7"=>"July", "8"=>"August", "9"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
				}
				else if($login['language']=='fr')
				{
					$arr_months = array("1"=>"Janvier", "2"=>"Février", "3"=>"mars", "4"=>"Avril", "5"=>"Mai", "6"=>"Juin", "7"=>"Juillet", "8"=>"Aout", "9"=>"Septembre", "10"=>"Octobre", "11"=>"Novembre", "12"=>"Decembre");
				}
				else if($login['language']=='sw')
				{
					$arr_months = array("1"=>"January", "2"=>"February", "3"=>"March", "4"=>"April", "5"=>"May", "6"=>"June", "7"=>"July", "8"=>"August", "9"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
				}
				?>
					<select id="month" class='form-control' name="month" >
						<option value=""><?php echo $content_lang['9']['content']." ".$content_lang['14']['content']; ?></option>
						<?php
						foreach($arr_months as $key=>$val)
						{
							if($key==$_POST['month'])
							{
								$mon_selected = "selected";
							}
							else 
							{
								$mon_selected = "";
							}
							echo "<option value='".$key."' $mon_selected >".$val."</option>";
						}
						?>
					</select>
				</td>
				<!--<td>
					<div class="form-group input-group date" id="from_datepicker">
						<input type="text" name="from_date" class="form-control" id="from_date"  value="<?php echo $from_date; ?>" placeholder="From Date" readonly>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
					<script type="text/javascript">
					$(function () {
						$('#from_datepicker').datetimepicker({
							format: 'YYYY-MM-DD',
							ignoreReadonly: true
						});
					});
					</script>
				</td>
				<td>
					<div class="form-group input-group date" id="to_datepicker">
						<input type="text" name="to_date" class="form-control" id="to_date"  value="<?php echo $to_date; ?>" placeholder="To Date" readonly>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
					<script type="text/javascript">
					$(function () {
						$('#to_datepicker').datetimepicker({
							format: 'YYYY-MM-DD',
							ignoreReadonly: true
						});
					});
					</script>
				</td>-->
				<input type="hidden" name="filter" value="1">
				<td class="text-center">
					<button type="submit" class="btn btn-success" onclick="validation();">
						<span class='glyphicon glyphicon-filter'></span>
						<?php echo $content_lang['25']['content']; ?>
					</button>
				</td>
				<?php if($from_date){ ?>
				<td class="text-center">
					<a href="include/content/export_report.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" class="btn btn-success">
						<span class='glyphicon glyphicon-export'></span>
						<?php echo $content_lang['27']['content']; ?>
					</a>
				</td>
				<?php } ?>
			</tr>
			</form>
		</table>
	</div>
	<?php
	//echo"<pre>";print_r($_POST);die;
	$filterDateYear = strtotime($_POST['year'].'-'.$_POST['month']);
	$monthyear = strtotime($monthyear);
	 ?>
		<!--<div style="float:right;">
		<?php
		//print_r($where_patient_id);
		
		$count=0;
		if(isset($where_patient_id) && $where_patient_id!='')
		{
			foreach($where_patient_id AS $patient_id)
			{
				$where['patient_id'] =  $patient_id;
				$rslt=$data->countData($con, "DISTINCT(patient_id)", TBL18, $where, "");
				$count=$count+$rslt['count'];
			}
		}
			require_once("../class/Pagination.class");
			$page_link=$page_name;
			$start=0;
			$limit=3000;
			$numrows=$count;
			$pagination = new Pagination($numrows, $start, $limit, $page_link);
			$start=$_REQUEST['start']?$_REQUEST['start']:0;
			echo $pagination->pager($start);
		?>
		</div>-->
		
		<div class="table-responsive1">
			<table class="table table-bordered table-hover">
				<thead>
					<tr class="info">
						<th>S NO.</th>
						<th><?php echo $content_lang['10']['content']; ?></th>
						<th><?php echo $content_lang['11']['content']; ?></th>
						<th><?php echo $content_lang['12']['content']; ?></th>
						<th><?php echo $content_lang['13']['content']; ?></th>
						<th><?php echo $content_lang['14']['content']; ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				function array_unique_multidimensional($array, $preserveKeys = false)
				{
					 // Unique Array for return
					$arrayRewrite = array();
					// Array with the md5 hashes
					$arrayHashes = array();
					foreach($array as $key => $item) {
						// Serialize the current element and create a md5 hash
						$hash = md5(serialize($item));
						// If the md5 didn't come up yet, add the element to
						// to arrayRewrite, otherwise drop it
						if (!isset($arrayHashes[$hash])) {
							// Save the current element hash
							$arrayHashes[$hash] = $hash;
							// Add element to the unique Array
							if ($preserveKeys) {
								$arrayRewrite[$key] = $item;
							} else {
								$arrayRewrite[] = $item;
							}
						}
					}
					return $arrayRewrite;
				}
				//print_r($where);
				if(isset($where_patient_id) && $where_patient_id!='')
					{
						$k=0;
						foreach($where_patient_id AS $patient_id)
						{
						$rslt=$data->getData($con, "IF(component_id=189, component_value, '') AS health_zone, IF(component_id=133, component_value, '') AS health_area, visit_time", TBL18, array("patient_id"=>$patient_id), "");
						if($rslt['status']==1)
						{
							$detail=$rslt['detail'];
							
							$health_zone="";
							$health_area="";
							$visit_time="";
							
							for($i=0; $i<sizeof($detail); $i++)
							{
								if($detail[$i]['health_zone'])
									$health_zone=$detail[$i]['health_zone'];
								if($detail[$i]['health_area'])
									$health_area=$detail[$i]['health_area'];
								if($detail[$i]['visit_time'])
									$visit_time=$detail[$i]['visit_time'];
							}
							
							//$save_data->setData($con, array("department"=>$content_lang['46']['content'], "health_zone"=>$health_zone, "health_area"=>$health_area, "visit_time"=>$visit_time), "report_list", array(id=>"Insert"));
							//$rslt=$save_data->insertData();
							$arr_unique_data[$k]['health_zone'] = $health_zone;
							$arr_unique_data[$k]['health_area'] = $health_area;
							$arr_unique_data[$k]['month'] = date("n", strtotime($visit_time));
							$arr_unique_data[$k]['year'] = date("Y", strtotime($visit_time));
						}
						$k++;
						}
					}
					if(count($arr_unique_data)>0)
					$arr_final= array_unique_multidimensional($arr_unique_data);
					//echo "<pre>";
					//print_r($arr_final);
					
					for($l=0; $l<sizeof($arr_final); $l++)
					{
						$encoded_health_zone=urlencode($arr_final[$l]['health_zone']);
						$encoded_health_area=urlencode($arr_final[$l]['health_area']);	
						$visit_year=$arr_final[$l]['year'];
						$visit_month=$arr_final[$l]['month'];
						$no=$l+1;
						echo"<tr onclick='getForm(\"ajax_pages/report_detail.php?health_zone=$encoded_health_zone&health_area=$encoded_health_area&visit_year=$visit_year&visit_month=$visit_month\", \"80%\")'>
								<td>".$no."</td>
								<td>".$content_lang['46']['content']."</td>
								<td>".$arr_final[$l]['health_zone']."</td>
								<td>".$arr_final[$l]['health_area']."</td>
								<td>".$visit_year."</td>
								<td>".$arr_months[$arr_final[$l]['month']]."</td>
							</tr>
						";
					}
					?>
				</tbody>
			</table>
		</div>
</div>