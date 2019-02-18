<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='UTF-8'>
	<title>Time Table</title>
</head>
<body>
<?php 
	include 'function.php'; 
	$class_id = $_REQUEST['class_id'];
	$szbranch_id =  $_REQUEST['szbranch_id'];
	$szschool_id = $_REQUEST['szschool_id'];
	$db = new Mysqli('localhost', 'root', '', 'ikolilu_b' );
?>

	<table style=" text-align: center; background-color: #00edff;">
			<tr style="background-color: #06ff00;">
				<th style="text-align: left; ">TIME</th><?php getTimeBf_f_Break($db,$class_id,$szbranch_id,$szschool_id); ?><?php Get_f_BreakTime($db,$class_id,$szbranch_id,$szschool_id); ?><?php getTimeBf_s_Break($db,$class_id,$szbranch_id,$szschool_id); ?><?php Get_s_BreakTime($db,$class_id,$szbranch_id,$szschool_id); ?><?php getTime_left($db,$class_id,$szbranch_id,$szschool_id); ?>
			</tr>			
			<tr>
				<th style="text-align: left; background-color: #06ff00;">MONDAY</th><?php SubBf_f_Break($db,'monday',$class_id,$szbranch_id,$szschool_id); ?><td rowspan="5" style="background-color: #06ff00;"> F<br>I<br>R<br>S<br>T <br><br> B<br>R<br>E<br>A<br>K </td><?php SubBf_s_Break($db,'monday',$class_id,$szbranch_id,$szschool_id); ?><td rowspan="5" style="background-color: #06ff00;"> S<br>E<br>C<br>O<br>N<br>D <br><br> B<br>R<br>E<br>A<br>K</td><?php Sub_left($db,'monday',$class_id,$szbranch_id,$szschool_id); ?>
			</tr>			
			<tr>
				<th style="text-align: left; background-color: #06ff00;">TUESDAY</th><?php SubBf_f_Break($db,'tuesday',$class_id,$szbranch_id,$szschool_id); ?><?php SubBf_s_Break($db,'tuesday',$class_id,$szbranch_id,$szschool_id); ?><?php Sub_left($db,'tuesday',$class_id,$szbranch_id,$szschool_id); ?>
			</tr>			
			<tr>
				<th style="text-align: left; background-color: #06ff00;">WEDNESDAY</th><?php SubBf_f_Break($db,'wednesday',$class_id,$szbranch_id,$szschool_id); ?><?php SubBf_s_Break($db,'wednesday',$class_id,$szbranch_id,$szschool_id); ?><?php Sub_left($db,'wednesday',$class_id,$szbranch_id,$szschool_id); ?>
			</tr>			
			<tr>
				<th style="text-align: left; background-color: #06ff00;">THURSDAY</th><?php SubBf_f_Break($db,'thursday',$class_id,$szbranch_id,$szschool_id); ?><?php SubBf_s_Break($db,'thursday',$class_id,$szbranch_id,$szschool_id); ?><?php Sub_left($db,'thursday',$class_id,$szbranch_id,$szschool_id); ?>
			</tr>			
			<tr>
				<th style="text-align: left; background-color: #06ff00;">FRIDAY</th><?php SubBf_f_Break($db,'friday',$class_id,$szbranch_id,$szschool_id); ?><?php SubBf_s_Break($db,'friday',$class_id,$szbranch_id,$szschool_id); ?><?phpSub_left($db,'friday',$class_id,$szbranch_id,$szschool_id); ?>
			</tr>

	</table>

</body>
</html>