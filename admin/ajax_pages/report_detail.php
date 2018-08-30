<?php
require_once ("../../include/config.php");
require_once ("../../include/".PAGE6.".php");
require_once ("../../class/Data.class");
$data=new Data();

error_reporting(E_ALL ^ E_NOTICE);
session_start();

$login=$_SESSION[APPLICATION_ID.'_login'];
$login_id=$login['login_id'];

if($login['language']!='')
	$language_code = $login['language'];
else
	$language_code = "en";

$table1 =TBL69;	
$data=new Data();
$data_language=$data->getData($con, "id, $language_code as content", "$table1 a", "", "");
$content_lang = $data_language['detail'];

//echo $language_code;
//print_r($_REQUEST);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript">  
$(document).ready(function(){
   
 }); 		
</script> 

<div class="col-sm-12 well">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>
					<?php
					$health_zone=preg_replace('~[\r\n]+~', '', $_REQUEST['health_zone']);
					$health_area=preg_replace('~[\r\n]+~', '', $_REQUEST['health_area']);
					$health_zone_id=$_REQUEST['health_zone_id'];
					$health_area_id=$_REQUEST['health_area_id'];
			
					if($_REQUEST['visit_month']=='12')
					{
						$year=$_REQUEST['visit_year']+1;
						$nextmonth=1;
					}
					else
					{
						$year=$_REQUEST['visit_year'];
						$nextmonth=$_REQUEST['visit_month']+1;
					}
					
					$lastreport=$data->getData($con, "visit_time", TBL18, array("MONTH(visit_time)"=>$nextmonth, "YEAR(visit_time)"=>$year), "ORDER BY id DESC LIMIT 1");
					$reporttime = $lastreport['detail'];
					//print_r($lastreport);
					if(isset($reporttime) && $reporttime[0]['visit_time']!='')
						echo "Report complete";
					else
					{
						$lastreport1=$data->getData($con, "visit_time", TBL18, array(), "ORDER BY id DESC LIMIT 1");
						$reporttime1 = $lastreport1['detail'];
						echo  "Report uploaded till ".date("d-M-Y", strtotime($reporttime1[0]['visit_time']));
					}
					?>
				</th>
			</tr>
		</thead>	
	</table>
			
	<div id="dvData3" class="col-sm-10">
		<h2 class="text-center"><?php echo $content_lang['47']['content']; ?></h2>
		<table class="table table-bordered">
			<thead>
				<tr class="info">
				<?php
					echo "<th>".$content_lang['10']['content']."</th>";
					//echo "<th>".$content_lang['22']['content']."</th>";
					echo "<th>".$content_lang['11']['content']."</th>";
					echo "<th>".$content_lang['12']['content']."</th>";
					echo "<th>".$content_lang['13']['content']."</th>";
					echo "<th>".$content_lang['14']['content']."</th>";
					$arr_export = array();
				?>
				</tr>
			</thead>
			<tbody>
			<tr>
			<?php
			if($language_code=='en')
				{
					$arr_months = array("1"=>"January", "2"=>"February", "3"=>"March", "4"=>"April", "5"=>"May", "6"=>"June", "7"=>"July", "8"=>"August", "9"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
				}
				else if($language_code=='fr')
				{
					$arr_months = array("1"=>"Janvier", "2"=>"Février", "3"=>"mars", "4"=>"Avril", "5"=>"Mai", "6"=>"Juin", "7"=>"Juillet", "8"=>"Aout", "9"=>"Septembre", "10"=>"Octobre", "11"=>"Novembre", "12"=>"Decembre");
				}
				else if($language_code=='sw')
				{
					$arr_months = array("1"=>"January", "2"=>"February", "3"=>"March", "4"=>"April", "5"=>"May", "6"=>"June", "7"=>"July", "8"=>"August", "9"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
				}
			
			$patient_id1=array();
			$patient_id2=array();
			
			$result=$con->query("SELECT DISTINCT patient_id FROM ".TBL18." a JOIN ".TBL2." b ON 
			a.data_entry_id=b.hcw_username WHERE b.hcw_zone_id='".$health_zone_id."' AND b.hcw_area_id='".$health_area_id."'
			AND YEAR(visit_time)='".$_REQUEST['visit_year']."' AND 
			MONTH(visit_time)='".$_REQUEST['visit_month']."'") OR die($con->error);
			
			while($row=$result->fetch_array())
			{
				$patient_id1[]=$row['patient_id'];
			}
			
			/*$result1=$con->query("SELECT patient_id FROM ".TBL18." a JOIN ".TBL2." b ON a.data_entry_id=b.hcw_username WHERE component_id=133 AND TRIM(BOTH '\n' FROM component_value)='".mysqli_real_escape_string($con, $health_area)."' AND YEAR(visit_time)='".$_REQUEST['visit_year']."' AND MONTH(visit_time)='".$_REQUEST['visit_month']."'") OR die($con->error);
			while($row1=$result1->fetch_array())
			{
				$patient_id2[]=$row1['patient_id'];
			}
			
			$arr_patient = array_merge($patient_id1, $patient_id2);
			$arr_patient_final = array_unique($arr_patient);*/
			
			$str_patient= implode("','", $patient_id1);
			//echo sizeof($patient_id1);
			//echo $str_patient;
			?>
					<td><?php echo $content_lang['46']['content'];
					$arr_export['department']=$content_lang['46']['content'];
					?></td>
					<!--<td><?php echo $_REQUEST['user_name']; 
					$arr_export['user_name']=$_REQUEST['user_name'];
					?></td>-->
					<td><?php echo $_REQUEST['health_zone']; 
					$arr_export['health_zone']=$_REQUEST['health_zone'];
					?></td>
					<td><?php echo $_REQUEST['health_area']; 
					$arr_export['health_area']=$_REQUEST['health_area'];
					?></td>
					<td><?php echo $_REQUEST['visit_year']; 
					$arr_export['year']=$_REQUEST['visit_year'];
					?></td>
					<td><?php echo $arr_months[$_REQUEST['visit_month']]; 
					$arr_export['month']=$arr_months[$_REQUEST['visit_month']]; 
					?></td>
				</tr>
			</tbody>
		</table>
		<table id="mytable" class="table table-bordered">
			<thead>
				<tr class="info">
				<th colspan=2 class='text-center'><?php echo $content_lang['48']['content']; ?></th>
				</tr>
				<tr class="info">
				<th colspan=2 class='text-left'>2. <?php echo $content_lang['68']['content']; ?></th>
				</tr>
				<tr class="info">
				<th colspan=2 class='text-left'>2.1 <?php echo $content_lang['49']['content']; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $content_lang['50']['content']; ?></td>
					<td>
						<?php
						$table=TBL18;
						//echo "SELECT SUM(IF(component_value IN('1st', 'CPN1', 'Kwanza'), 1, 0)) AS cpn1, SUM(IF(component_value IN('2nd', 'CPN2', 'Pili'), 1, 0)) AS cpn2,  SUM(IF(component_value IN('3rd', 'CPN3', 'Tatu'), 1, 0)) AS cpn3, SUM(IF(component_value IN('4+', 'CPN4+', 'Ya nne'), 1, 0)) AS cpn4 FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='237' and patient_id in ('$str_patient')";
						$query=$con->query("SELECT SUM(IF(component_value IN('1st', 'CPN1', 'Kwanza'), 1, 0)) AS cpn1, SUM(IF(component_value IN('2nd', 'CPN2', 'Pili'), 1, 0)) AS cpn2,  SUM(IF(component_value IN('3rd', 'CPN3', 'Tatu'), 1, 0)) AS cpn3, SUM(IF(component_value IN('4+', 'CPN4+', 'Ya nne'), 1, 0)) AS cpn4 FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='237' and patient_id in ('$str_patient')") OR die($con->error);
						$result = $query->fetch_assoc();
						//print_r($result);
						echo $arr_export['cpn1'] = $result['cpn1']!=''?$result['cpn1']:0;
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['51']['content']; ?></td>
					<td>
						<?php 
						$result1=$con->query("SELECT IF(component_value IN('1st', 'CPN1', 'Kwanza'), patient_id, '') AS patient_id FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' AND YEAR(visit_time)='".$_REQUEST['visit_year']."' AND component_id='237' and patient_id in ('$str_patient')") OR die($con->error);
						while($row = $result1->fetch_assoc())
						{
							if($row['patient_id'])
							{
								$patient_id .="$coma'".$row['patient_id']."'";
								if(!$coma)
									$coma=",";
								
							}
						}
						if(!$patient_id)
						$patient_id="''";
						//echo $patient_id;
						$result1=$con->query("SELECT SUM(IF(component_value IN('4 months', '4 mois', 'Miezi ine'), 1, 0)) AS cpn1_16 FROM $table WHERE patient_id IN($patient_id) AND component_id='220' and patient_id in ('$str_patient')") OR die($con->error);
						$row = $result1->fetch_assoc();
						echo $arr_export['cpn1_16'] = $row['cpn1_16']!=''?$row['cpn1_16']:0;
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['52']['content']; ?></td>
					<td>
						<?php echo $arr_export['cpn2'] = $result['cpn2']!=''?$result['cpn2']:0;	?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['53']['content']; ?></td>
					<td>
					<?php echo $arr_export['cpn3'] = $result['cpn3']!=''?$result['cpn3']:0;	?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['54']['content']; ?></td>
					<td>
					<?php echo $arr_export['cpn4'] =$result['cpn4']!=''?$result['cpn4']:0; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['83']['content']; ?></td>
					<td>
						<?php 
						$result1=$con->query("SELECT IF(component_value IN('4+', 'CPN4+', 'Ya nne'), patient_id, '') AS patient_id FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' AND YEAR(visit_time)='".$_REQUEST['visit_year']."' AND component_id='237' and patient_id in ('$str_patient')") OR die($con->error);
						$patient_id="";
						$coma="";
						while($row = $result1->fetch_assoc())
						{
							if($row['patient_id'])
							{
								$patient_id .="$coma'".$row['patient_id']."'";
								if(!$coma)
									$coma=",";
							}
						}
						if(!$patient_id)
						$patient_id="''";
						//echo $patient_id;
						$result1=$con->query("SELECT SUM(IF(component_value IN('9 months', '9 mois', 'Miezi kenda'), 1, 0)) AS cpn4_36 FROM $table WHERE patient_id IN($patient_id) AND component_id='220'") OR die($con->error);
						$row = $result1->fetch_assoc();
						echo $arr_export['cpn4_36'] = $row['cpn4_36']!=''?$row['cpn4_36']:0;
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['55']['content']; ?></td>
					<td>
					<?php
					$query1=$con->query("SELECT SUM(IF(component_value IN('Iron Folate 1', 'Fer Folate 1'), 1, 0)) AS iron1, SUM(IF(component_value IN('Iron Folate 2', 'Fer Folate 2'), 1, 0)) AS iron2, SUM(IF(component_value IN('Iron Folate 3+', 'Fer Folate 3+'), 1, 0)) AS iron3 FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='367' and patient_id in ('$str_patient')") OR die($con->error);
					$result1 = $query1->fetch_assoc();//print_r($rslt);
					
					echo $arr_export['iron1'] =$result1['iron1']!=''?$result1['iron1']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['56']['content']; ?></td>
					<td>
					<?php echo $arr_export['iron2'] =$result1['iron2']!=''?$result1['iron2']:0; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['57']['content']; ?></td>
					<td>
					<?php echo $arr_export['iron3'] =$result1['iron3']!=''?$result1['iron3']:0; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['58']['content']; ?></td>
					<td>
					<?php 
					$query2=$con->query("SELECT SUM(IF(component_value LIKE '%Fansidar (SP) 1%', 1, 0)) AS sulfadox1, SUM(IF(component_value LIKE '%Fansidar (SP) 2%', 1, 0)) AS sulfadox2, SUM(IF(component_value LIKE '%Fansidar (SP) 3%', 1, 0)) AS sulfadox3, SUM(IF(component_value LIKE '%Fansidar (SP) 4%', 1, 0)) AS sulfadox4 FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='363' and patient_id in ('$str_patient')") OR die($con->error);
					$result2 = $query2->fetch_assoc();
					echo $arr_export['sulfadox1'] =$result2['sulfadox1']!=''?$result2['sulfadox1']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['59']['content']; ?></td>
					<td>
					<?php echo $arr_export['sulfadox2'] =$result2['sulfadox2']!=''?$result2['sulfadox2']:0; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['60']['content']; ?></td>
					<td>
					<?php echo $arr_export['sulfadox3'] =$result2['sulfadox3']!=''?$result2['sulfadox3']:0; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['61']['content']; ?></td>
					<td>
					<?php echo $arr_export['sulfadox4'] =$result2['sulfadox4']!=''?$result2['sulfadox4']:0; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['62']['content']; ?></td>
					<td>
					<?php
					$result1=$con->query("SELECT IF(component_value IN('Received', 'déjà reçu', 'Amekwisha pokea'), patient_id, '') AS patient_id FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' AND YEAR(visit_time)='".$_REQUEST['visit_year']."' AND component_id='344' and patient_id in ('$str_patient')") OR die($con->error);
					$patient_id="";
					$coma="";
					while($row = $result1->fetch_assoc())
					{
						if($row['patient_id'])
						{
							$patient_id .="$coma'".$row['patient_id']."'";
							if(!$coma)
								$coma=",";
						}
					}
					if(!$patient_id)
						$patient_id="''";
					//echo $patient_id;
					$result1=$con->query("SELECT SUM(IF(component_value IN('1st', 'CPN1', 'Kwanza'), 1, 0)) AS mosquito, SUM(IF(component_value NOT IN('1st', 'CPN1', 'Kwanza'), 1, 0)) AS mosquito1 FROM $table WHERE patient_id IN($patient_id) AND component_id='237' and patient_id in ('$str_patient')") OR die($con->error);
					$row = $result1->fetch_assoc();
					echo $arr_export['mosquito']=$row['mosquito']?$row['mosquito']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['63']['content']; ?></td>
					<td>
					<?php
					echo $arr_export['mosquito1']=$row['mosquito1']?$row['mosquito1']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['64']['content']; ?></td>
					<td>
					<?php
					$query4=$con->query("SELECT SUM(IF(component_value<23, 1, 0)) AS pregnant FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' AND YEAR(visit_time)='".$_REQUEST['visit_year']."' AND component_id='214' and patient_id in ('$str_patient')") OR die($con->error);
					$result4=$query4->fetch_array();
					echo $arr_export['pregnant']=$result4['pregnant']?$result4['pregnant']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['65']['content']; ?></td>
					<td>
					<?php
					$query5=$con->query("SELECT SUM(IF(component_value IN('YES', 'OUI', 'NDIO'), 1, 0)) AS pregnant1 FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' AND YEAR(visit_time)='".$_REQUEST['visit_year']."' AND component_id='429' and patient_id in ('$str_patient')") OR die($con->error);
					$result5=$query5->fetch_array();
					echo $arr_export['pregnant1']=$result5['pregnant1']?$result5['pregnant1']:0;
					?>
					</td>
				</tr>
				<tr class="info">
				<th colspan=2 class='text-left'>2.2  <?php echo $content_lang['66']['content']; ?></th>
				</tr>
				<tr>
					<td><?php echo $content_lang['67']['content']; ?> 1</td>
					<td>
					<?php			
					$query6=$con->query("SELECT SUM(IF(component_value IN('Tetanus Vaccine 1', 'Vaccin anti tétanique 1', 'Chanjo ya pepopunda 1'), 1, 0)) AS vat1, SUM(IF(component_value IN('Tetanus Vaccine 2', 'Vaccin anti tétanique 2', 'Chanjo ya pepopunda 2'), 1, 0)) AS vat2, SUM(IF(component_value IN('Tetanus Vaccine 3', 'Vaccin anti tétanique 3', 'Chanjo ya pepopunda 3'), 1, 0)) AS vat3, SUM(IF(component_value IN('Tetanus Vaccine 4', 'Vaccin anti tétanique 4', 'Chanjo ya pepopunda 4'), 1, 0)) AS vat4, SUM(IF(component_value IN('Tetanus Vaccine 5', 'Vaccin anti tétanique 5', 'Chanjo ya pepopunda 5'), 1, 0)) AS vat5 FROM $table WHERE MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='26' and patient_id in ('$str_patient')") OR die($con->error);
					$result6 = $query6->fetch_assoc();
					
					echo $arr_export['vat1'] = $result6['vat1']!=''?$result6['vat1']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['67']['content']; ?> 2</td>
					<td>
					<?php echo $arr_export['vat2'] = $result6['vat2']!=''?$result6['vat2']:0; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['67']['content']; ?> 3</td>
					<td>
					<?php echo $arr_export['vat3'] = $result6['vat3']!=''?$result6['vat3']:0; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['67']['content']; ?> 4</td>
					<td>
					<?php echo $arr_export['vat4'] = $result6['vat4']!=''?$result6['vat4']:0; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['67']['content']; ?> 5</td>
					<td>
					<?php echo $arr_export['vat5'] = $result6['vat5']!=''?$result6['vat5']:0; ?>
					</td>
				</tr>	
			</tbody>
		</table>
	</div>
	<div class="col-sm-2" >
		<div class="col-sm-12 text-center" style="margin-top:55px;">
		<h4 class="col-sm-12" style="background-color:#d9edf7; padding:10px; border:1px solid #ddd;" ><?php echo $content_lang['69']['content']; ?></h4>
				<div class="col-sm-12 text-center" style="margin-top:20px;">
				<a  href="include/content/export_patient_report_csv.php?export_data=<?php echo urlencode(json_encode($arr_export)); ?>" style="color:#000; text-decoration:none;">
					<span class='glyphicon fa fa-file-excel-o' style="color:green; font-size:70px;"></span><br> CSV&nbsp; 
				</a>
				</div>
				
				<div class="col-sm-12 text-center" style="margin-top:20px;">
				<a  href="include/content/export_patient_report_excel.php?export_data=<?php echo urlencode(json_encode($arr_export)); ?>" style="color:#000; text-decoration:none;">
					<span class='glyphicon fa fa-file-excel-o' style="color:green; font-size:70px;" ></span><br> Excel&nbsp;
				</a>
				</div>
				
				<div class="col-sm-12 text-center" style="margin-top:20px;">
				<a  href="include/content/export_patient_report_pdf.php?export_data=<?php echo urlencode(json_encode($arr_export)); ?>" style="color:#000; text-decoration:none;" target="_blank" >
					<span class='glyphicon fa fa-file-pdf-o' style="color:red; font-size:70px;"></span><br> PDF&nbsp;
				</a>
				</div>	
		</div>
	</div>
</div>