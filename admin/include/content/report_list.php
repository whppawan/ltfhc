<script text="text/javascript">
$(document).ready(function(){
	$('#total').html('<?php echo $content_lang['26']['content']; ?>');
});
</script>

<?php
$page_name="?page=$page";
require_once ("../class/Data.class");

$data=new Data();
$where=array();

if($_POST['filter'])
{
	if($_POST['user_name']!='')
		$where['data_entry_id']=$_POST['user_name'];
	if($_POST['health_zone_id']!='')
		$where['hcw_zone_id']=$_POST['health_zone_id'];
	if($_POST['health_area_id']!='')
		$where['hcw_area_id']=$_POST['health_area_id'];
	if($_POST['year']!='')
		$where['YEAR(visit_time)']=$_POST['year'];
	if($_POST['month']!='')
		$where['MONTH(visit_time)']=$_POST['month'];
}

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
				<!--<td>
					<select class='form-control' name="user_name">
						<option value=""><?php echo $content_lang['9']['content']." ".$content_lang['22']['content']; ?></option>
						<?php
						/*$detail=$data->getData($con, "a.hcw_username", TBL2." a", array("a.status"=>1), "ORDER BY a.hcw_username");
						if($detail['status']==1)
						{
							$rslt=$detail['detail'];
							for($i=0; $i<sizeof($rslt); $i++)
							{
								$hcw_username=trim($rslt[$i]['hcw_username']);
								//$component_value=preg_replace('~[\r\n]+~', '', $rslt[$i]['component_value']);
								//$component_value=mysqli_real_escape_string($con, $component_value);
								if($hcw_username==$_POST['user_name'])
									$username_selected = "selected";
								else 
									$username_selected = "";
								
								echo '<option value="'.$hcw_username.'" '.$username_selected.' >'.$hcw_username.'</option>';
							}
						}
						else
							echo "<option value=''>".$detail['msg']."</option>";*/
						?>
					</select>
				</td>-->
				<td>
					<select class='form-control' name="health_zone_id" id="health_zone_id" onchange="getChangedData('<?php echo TBL6; ?>', 'health_zone_id', this.value, 'health_area_id')">
						<option value="">
							<?php echo $content_lang['9']['content']." ".$content_lang['11']['content']; ?>
						</option>
						<?php
						$rslt=$data->getData($con, "a.id, a.name", TBL5." a", array("a.status"=>1), "ORDER BY a.name");
						if($rslt['status']==1)
						{
							$detail=$rslt['detail'];
							for($i=0; $i<sizeof($detail); $i++)
							{
								$health_zone_id=$detail[$i]['id'];
								$health_zone_name=$detail[$i]['name'];
								if($health_zone_id==$_POST['health_zone_id'])
									$hzone_selected = "selected";
								else 
									$hzone_selected = "";
								
								echo '<option value="'.$health_zone_id.'" '.$hzone_selected.' >'.$health_zone_name.'</option>';
							}
						}
						else
							echo "<option value=''></option>";
						?>
					</select>
				</td>
				<td>
					<select class='form-control' name="health_area_id" id="health_area_id">
						<option value=""><?php echo $content_lang['9']['content']." ".$content_lang['12']['content']; ?></option>
						<?php
						$rslt=$data->getData($con, "a.id, a.name", TBL6." a", array("a.status"=>1, "a.health_zone_id"=>$_POST['health_zone_id']), "ORDER BY a.name");
						if($rslt['status']==1)
						{
							$detail=$rslt['detail'];
							for($i=0; $i<sizeof($detail); $i++)
							{
								$health_area_id=$detail[$i]['id'];
								$health_area_name=$detail[$i]['name'];
								if($health_area_id==$_POST['health_area_id'])
									$harea_selected = "selected";
								else 
									$harea_selected = "";
								
								echo "<option value='$health_area_id' $harea_selected >$health_area_name</option>";
							}
						}
						else
							echo "<option value=''></option>";
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
		
		/*$count=0;
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
			echo $pagination->pager($start);*/
		?>
		</div>-->
		
		<div class="table-responsive1">
			<table class="table table-bordered table-hover">
				<thead>
					<tr class="info">
						<th>S NO.</th>
						<th><?php echo $content_lang['10']['content']; ?></th>
						<!--<th><?php echo $content_lang['22']['content']; ?></th>-->
						<th><?php echo $content_lang['11']['content']; ?></th>
						<th><?php echo $content_lang['12']['content']; ?></th>
						<th><?php echo $content_lang['13']['content']; ?></th>
						<th><?php echo $content_lang['14']['content']; ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$rslt=$data->getData($con, "a.data_entry_id, b.hcw_zone_id, b.hcw_area_id, YEAR(a.visit_time) AS visit_year, MONTH(a.visit_time) AS visit_month, c.name AS health_zone, d.name AS health_area", TBL18." a JOIN ".TBL2." b ON a.data_entry_id=b.hcw_username JOIN ".TBL5." c ON b.hcw_zone_id=c.id JOIN ".TBL6." d ON b.hcw_area_id=d.id", $where, "GROUP BY data_entry_id, visit_year, visit_month ORDER BY visit_time DESC");
					//print_r($rslt);
					if($rslt['status']==1)
					{
						$detail=$rslt['detail'];
						for($l=0; $l<sizeof($detail); $l++)
						{
							$user_name=$detail[$l]['data_entry_id'];
							$health_zone=$detail[$l]['health_zone'];
							$health_zone_id=$detail[$l]['hcw_zone_id'];
							$health_area=$detail[$l]['health_area'];
							$health_area_id=$detail[$l]['hcw_area_id'];
							$visit_year=$detail[$l]['visit_year'];
							$visit_month1=$detail[$l]['visit_month'];
							$visit_month=date("F", mktime(0, 0, 0, $detail[$l]['visit_month'], 10));
							$no=$l+1;
							echo"<tr onclick='getForm(\"ajax_pages/report_detail.php?user_name=$user_name&health_zone_id=$health_zone_id&health_zone=$health_zone&health_area_id=$health_area_id&health_area=$health_area&visit_year=$visit_year&visit_month=$visit_month1\", \"80%\")'>
									<td>".$no."</td>
									<td>".$content_lang['46']['content']."</td>
									<!--<td>".$user_name."</td>-->
									<td>".$health_zone."</td>
									<td>".$health_area."</td>
									<td>".$visit_year."</td>
									<td>".$arr_months[$visit_month1]."</td>
								</tr>
							";
						}
					}
					?>
				</tbody>
			</table>
		</div>
</div>