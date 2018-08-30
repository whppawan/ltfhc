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
			
					if($_REQUEST['visit_month']=='12')
						$nextmonth=1;
					else
						$nextmonth=$_REQUEST['visit_month']+1;
					
					$lastreport=$data->getData($con, "visit_time", TBL18, array("component_id">=189, "MONTH(visit_time)"=>$nextmonth, "YEAR(visit_time)"=>$_REQUEST['visit_year']), "ORDER BY id DESC LIMIT 1");
					$reporttime = $lastreport['detail'];
					//print_r($reporttime);
					if(isset($reporttime) && $reporttime[0]['visit_time']!='')
						echo "Report complete";
					else
					{
						$lastreport1=$data->getData($con, "visit_time", TBL18, array("component_id">=189), "ORDER BY id DESC LIMIT 1");
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
			
			$result=$con->query("SELECT patient_id FROM ".TBL18." WHERE component_id=189 AND TRIM(BOTH '\n' FROM component_value)='".mysqli_real_escape_string($con, $health_zone)."' AND YEAR(visit_time)='".$_REQUEST['visit_year']."' AND MONTH(visit_time)='".$_REQUEST['visit_month']."'") OR die($con->error);
			while($row=$result->fetch_array())
			{
				$patient_id1[]=$row['patient_id'];
			}
			
			$result1=$con->query("SELECT patient_id FROM ".TBL18." WHERE component_id=133 AND TRIM(BOTH '\n' FROM component_value)='".mysqli_real_escape_string($con, $health_area)."' AND YEAR(visit_time)='".$_REQUEST['visit_year']."' AND MONTH(visit_time)='".$_REQUEST['visit_month']."'") OR die($con->error);
			while($row1=$result1->fetch_array())
			{
				$patient_id2[]=$row1['patient_id'];
			}
			
			$arr_patient = array_merge($patient_id1, $patient_id2);
			$arr_patient_final = array_unique($arr_patient);
			
			$str_patient= implode("','", $arr_patient_final);
			?>
					<td><?php echo $content_lang['46']['content']; ?></td>
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
						$query=$con->query("SELECT SUM(IF((component_value='1st' OR component_value='CPN1'), 1, 0)) AS cpn1, SUM(IF((component_value='2nd' OR component_value='CPN2'), 1, 0)) AS cpn2, SUM(IF(component_value!='1st' && component_value!='2nd' && component_value!='3rd', 1, 0)) AS cpn3, SUM(IF(component_value='3rd', 1, 0)) AS cpn3, SUM(IF(component_value='4th', 1, 0)) AS cpn1_16 FROM $table WHERE patient_id in ('$str_patient') and  MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='237'") OR die($con->error);
						$result = $query->fetch_assoc();
						//print_r($result);
						
						echo $result['cpn1']!=''?$result['cpn1']:0;
						$arr_export['cpn1'] = $result['cpn1']!=''?$result['cpn1']:0;
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['51']['content']; ?></td>
					<td><?php echo $result['cpn1_16']!=''?$result['cpn1_16']:0;	
					$arr_export['cpn1_16'] = $result['cpn1_16']!=''?$result['cpn1_16']:0;
					?></td>
				</tr>
				<tr>
					<td><?php echo $content_lang['52']['content']; ?></td>
					<td>
						<?php echo $result['cpn2']!=''?$result['cpn2']:0;	
						$arr_export['cpn2'] = $result['cpn2']!=''?$result['cpn2']:0;	
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['53']['content']; ?></td>
					<td>
					<?php echo $result['cpn3']!=''?$result['cpn3']:0;	
					$arr_export['cpn3'] = $result['cpn3']!=''?$result['cpn3']:0;	
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['54']['content']; ?></td>
					<td>
					<?php echo $result['cpn4']!=''?$result['cpn4']:0;	
					$arr_export['cpn4'] =$result['cpn4']!=''?$result['cpn4']:0;	
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['55']['content']; ?></td>
					<td>
					<?php
					$query1=$con->query("SELECT SUM(IF(component_value='1', 1, 0)) AS iron1, SUM(IF(component_value='2', 1, 0)) AS iron2, SUM(IF(component_value>=3, 1, 0)) AS iron3 FROM $table WHERE patient_id in ('$str_patient') and  MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='367'") OR die($con->error);
					$result1 = $query1->fetch_assoc();//print_r($rslt);
					
					echo $result1['iron1']!=''?$result1['iron1']:0;
					$arr_export['iron1'] =$result1['iron1']!=''?$result1['iron1']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['56']['content']; ?></td>
					<td>
					<?php 
					echo $result1['iron2']!=''?$result1['iron2']:0;	
					$arr_export['iron2'] =$result1['iron2']!=''?$result1['iron2']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['57']['content']; ?></td>
					<td>
					<?php 
					echo $result1['iron3']!=''?$result1['iron3']:0;	
					$arr_export['iron3'] =$result1['iron3']!=''?$result1['iron3']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['58']['content']; ?></td>
					<td>
					<?php 
					$query2=$con->query("SELECT SUM(IF(component_value='Fansidar (SP) 1', 1, 0)) AS sulfadox1, SUM(IF(component_value='Fansidar (SP) 2', 1, 0)) AS sulfadox2, SUM(IF(component_value='Fansidar (SP) 3', 1, 0)) AS sulfadox3, SUM(IF(component_value='Fansidar (SP) 4', 1, 0)) AS sulfadox4 FROM $table WHERE patient_id in ('$str_patient') and  MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='363'") OR die($con->error);
					$result2 = $query2->fetch_assoc();
					echo $result2['sulfadox1']!=''?$result2['sulfadox1']:0;
					$arr_export['sulfadox1'] =$result2['sulfadox1']!=''?$result2['sulfadox1']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['59']['content']; ?></td>
					<td>
					<?php
					echo $result2['sulfadox2']!=''?$result2['sulfadox2']:0;
					$arr_export['sulfadox2'] =$result2['sulfadox2']!=''?$result2['sulfadox2']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['60']['content']; ?></td>
					<td>
					<?php echo $result2['sulfadox3']!=''?$result2['sulfadox3']:0; 
					$arr_export['sulfadox3'] =$result2['sulfadox3']!=''?$result2['sulfadox3']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['61']['content']; ?></td>
					<td>
					<?php
					echo $result2['sulfadox4']!=''?$result2['sulfadox4']:0;
					$arr_export['sulfadox4'] =$result2['sulfadox4']!=''?$result2['sulfadox4']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['62']['content']; ?></td>
					<td>
					<?php
					$query3=$con->query("SELECT component_value FROM $table WHERE patient_id in ('$str_patient') and  MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='344'") OR die($con->error);
					//print_r($result3);
					$mosquito=0;
					$mosquito1=0;
					while($result3=$query3->fetch_array())
						{
							if($result3['component_value']=='1st')
							{
								$mosquito = $mosquito+1;
							}
							if($result3['component_value']=='2nd')
							{
								$mosquito1 = $mosquito1+1;
							}
						}
					echo $mosquito;
					$arr_export['mosquito'] = $mosquito;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['63']['content']; ?></td>
					<td>
					<?php
					echo $mosquito1;
					$arr_export['mosquito1'] = $mosquito1;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['64']['content']; ?></td>
					<td>
					<?php
					$query4=$con->query("SELECT component_value FROM $table WHERE patient_id in ('$str_patient') and  MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='214'") OR die($con->error);
					$pregnant=0;
					while($result4=$query4->fetch_array())
						{		
							if($result4['component_value']<23)
								{
									$pregnant = $pregnant+1;
								}
						}
						
					echo $pregnant;
					$arr_export['pregnant'] = $pregnant;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['65']['content']; ?></td>
					<td>
					<?php
					$query5=$con->query("SELECT component_value FROM $table WHERE patient_id in ('$str_patient') and  MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='429'") OR die($con->error);
					$pregnant1=0;
					while($result5=$query5->fetch_array())
						{		
							if($result5['component_value']=='Yes')
								{
									$pregnant1 = $pregnant1+1;
								}
						}
					echo $pregnant1;
					$arr_export['pregnant1'] = $pregnant1;
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
					//$detail6=$data->getData($con, "component_value", TBL18, array("component_id"=>26), "");
					$detail6=$data->getData($con, "SUM(IF(component_value='Tetanus Vaccine 1', 1, 0)) AS vat1, SUM(IF(component_value='Tetanus Vaccine 2', 1, 0)) AS vat2, SUM(IF(component_value='Tetanus Vaccine 3', 1, 0)) AS vat3, SUM(IF(component_value='Tetanus Vaccine 4', 1, 0)) AS vat4, SUM(IF(component_value='Tetanus Vaccine 5', 1, 0)) AS vat5", TBL18, array("component_id"=>26), "");
					
					$query6=$con->query("SELECT SUM(IF(component_value='Tetanus Vaccine 1', 1, 0)) AS vat1, SUM(IF(component_value='Tetanus Vaccine 2', 1, 0)) AS vat2, SUM(IF(component_value='Tetanus Vaccine 3', 1, 0)) AS vat3, SUM(IF(component_value='Tetanus Vaccine 4', 1, 0)) AS vat4, SUM(IF(component_value='Tetanus Vaccine 5', 1, 0)) AS vat5 FROM $table WHERE patient_id in ('$str_patient') and  MONTH(visit_time)='".$_REQUEST['visit_month']."' and YEAR(visit_time)='".$_REQUEST['visit_year']."' and component_id='26'") OR die($con->error);
					$result6 = $query6->fetch_assoc();
					
					echo $result6['vat1']!=''?$result6['vat1']:0;
					$arr_export['vat1'] = $result6['vat1']!=''?$result6['vat1']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['67']['content']; ?> 2</td>
					<td>
					<?php
					echo $result6['vat2']!=''?$result6['vat2']:0;
					$arr_export['vat2'] = $result6['vat2']!=''?$result6['vat2']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['67']['content']; ?> 3</td>
					<td>
					<?php
					echo $result6['vat3']!=''?$result6['vat3']:0;
					$arr_export['vat3'] = $result6['vat3']!=''?$result6['vat3']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['67']['content']; ?> 4</td>
					<td>
					<?php
					echo $result6['vat4']!=''?$result6['vat4']:0;
					$arr_export['vat4'] = $result6['vat4']!=''?$result6['vat4']:0;
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $content_lang['67']['content']; ?> 5</td>
					<td>
					<?php
					echo $result6['vat5']!=''?$result6['vat5']:0;
					$arr_export['vat5'] = $result6['vat5']!=''?$result6['vat5']:0;
					?>
					</td>
				</tr>	
			</tbody>
		</table>
	</div>
	<div class="col-sm-2" >
		<div class="col-sm-12 text-center" style="margin-top:55px;">
		<h4 class="col-sm-12" style="background-color:#d9edf7; padding:10px; border:1px solid #ddd;" ><?php echo $content_lang['69']['content']; ?></h4>
				<div class="col-sm-12 text-center" style="margin-top:20px;">
				<a  href="include/content/export_patient_report_csv.php?export_data=<?php echo htmlentities(serialize($arr_export)); ?>" style="color:#000; text-decoration:none;">
					<span class='glyphicon fa fa-file-excel-o' style="color:green; font-size:70px;"></span><br> CSV&nbsp; 
				</a>
				</div>
				
				<div class="col-sm-12 text-center" style="margin-top:20px;">
				<a  href="include/content/export_patient_report_excel.php?export_data=<?php echo htmlentities(serialize($arr_export)); ?>" style="color:#000; text-decoration:none;">
					<span class='glyphicon fa fa-file-excel-o' style="color:green; font-size:70px;" ></span><br> Excel&nbsp;
				</a>
				</div>
				
				<div class="col-sm-12 text-center" style="margin-top:20px;">
				<a  href="include/content/export_patient_report_pdf.php?export_data=<?php echo htmlentities(serialize($arr_export)); ?>" style="color:#000; text-decoration:none;" target="_blank" >
					<span class='glyphicon fa fa-file-pdf-o' style="color:red; font-size:70px;"></span><br> PDF&nbsp;
				</a>
				</div>	
		</div>
	</div>
</div>