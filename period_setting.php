<?php 

$sz_classid =  'pri2';
$sz_branchid = 'gg1000zde';
$sz_schoolid = 'gg1000';
$db = new Mysqli('localhost', 'root', '', 'ikolilu_a' );
/*$SQL =  "SELECT `sz_periods` FROM `acc_periods` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'";
				foreach ($db->query($SQL) as $row) {
					$sz_periods = $row['sz_periods'];
					echo "<option value='07:30  - 08:10'> 07:30  - 08:10 </option>";
				}
				*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Time Table Setting Up</title>
</head>
<body style=" padding:10px;">
  <div style="padding:7px; float: left; background-color: #00edff;">
  	Period Settings<br><br>
	<form method="post" action="academics/pro_periods_.php">
		<label>Start Time:</label> &nbsp; <label>End Time:</label> <br>
		&nbsp;&nbsp;<select name="sz_start">
			<?php for($h=1;$h<=12; $h++){  
					for($m=0;$m<10; $m++){ 
						if (strlen($h) == '1') {
								$h = '0'.$h;
						}
			?>
				<option value="<?php echo $h.':0'.$m;?>"><?php echo $h .':0'.$m;?></option>
			<?php } ?>
			<?php for($m=10;$m<60; $m++){ 
					if (strlen($h) == '1') {
						$h = '0'.$h;
					}
			?>			
				<option value="<?php echo $h.':'.$m;?>"><?php echo $h.':'.$m;?></option>
			<?php } } ?>									
		</select>
		&nbsp;&nbsp;
		<select name="sz_end">
			<?php for($h=1;$h<=12; $h++){  
					for($m=0;$m<10; $m++){ 
						if (strlen($h) == '1') {
								$h = '0'.$h;
						}
			?>
				<option value="<?php echo $h.':0'.$m;?>"><?php echo $h .':0'.$m;?></option>
			<?php } ?>
			<?php for($m=10;$m<60; $m++){ 
					if (strlen($h) == '1') {
						$h = '0'.$h;
					}
			?>			
				<option value="<?php echo $h.':'.$m;?>"><?php echo $h.':'.$m;?></option>
			<?php } } ?>									
		</select>&nbsp;
		<!--some form of session storage-->
		<input type="hidden" name="sz_classid" value="<?php echo $sz_classid?>">
		<input type="hidden" name="sz_branchid" value="<?php echo $sz_branchid?>">
		<input type="hidden" name="sz_schoolid" value="<?php echo $sz_schoolid?>">
		<button type="submit" name="btn" value="Save">Save</button>	
	</form>
	<br>
	Time Table Allocation Settings<br><br>	
	<form method="post" action="academics/pro_timetable_.php">
		<label>Period:</label> <select name="sz_period">
			<?php
				$SQL =  mysqli_query($db,"SELECT `sz_periodid`,`sz_period` FROM `acc_periods` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'");
				while($row = mysqli_fetch_array($SQL)){
					$sz_period = $row['sz_period'];
					$sz_periodid = $row['sz_periodid'];
					echo "<option value='$sz_period' title='$sz_period'> period ".$sz_periodid."</option>";
				}
			?>
		</select> <button type="submit" name="btn" value="DropPeriods">Drop</button><br><br>
		<label>Monday</label><input type="checkbox" name="sz_dayid[]" value="1" checked="checked">
		<label>Tuesday</label><input type="checkbox" name="sz_dayid[]" value="2">
		<label>Wednesday</label><input type="checkbox" name="sz_dayid[]" value="3"><br><br>
		<label>Thursday</label><input type="checkbox" name="sz_dayid[]" value="4">
		<label>Friday</label><input type="checkbox" name="sz_dayid[]" value="5">
		<label>Saturday</label><input type="checkbox" name="sz_dayid[]" value="6"><br><br>
		<label>Sunday</label><input type="checkbox" name="sz_dayid[]" value="7">
		<br><br>
		<label>Teacher:</label> <select name="sz_teacherid">
			<option value='0'>  </option>
			<?php
				$SQL =  mysqli_query($db,"SELECT `sz_teacherid`,`sz_teachername` FROM `acc_teachers` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'");
				while($row = mysqli_fetch_array($SQL)){
					$sz_teacherid = $row['sz_teacherid'];
					$sz_teachername = $row['sz_teachername'];
					echo "<option value='$sz_teacherid'> $sz_teachername </option>";
				}
			?>
		</select>		
		<br><br>
		<label>Period Allocation:</label> <select name="sz_per_allo">
			<option value='ASSEMBLY'> ASSEMBLY </option>
			<option value='BREAK'> BREAK </option>
			<option value='CLOSE'> CLOSE </option>
			<option value='OTHERS'> FREE PERIOD </option>
			<?php 
				$SQL =  mysqli_query($db,"SELECT `sz_subjectname` FROM `acc_subjects` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'");
				while($row = mysqli_fetch_array($SQL)){
					$sz_subject = $row['sz_subjectname'];
					echo "<option value='$sz_subject'> $sz_subject </option>";
				}
			?>
		</select>
		<div style="text-align: right; padding: 10px;">
		<input type="hidden" name="sz_classid" value="<?php echo $sz_classid?>">
		<input type="hidden" name="sz_branchid" value="<?php echo $sz_branchid?>">
		<input type="hidden" name="sz_schoolid" value="<?php echo $sz_schoolid?>">
			<button type="submit" name="btn" value="Update">Update</button>
			<button type="submit" name="btn" value="Save">Save</button>
		</div>
		<br>
	</form>
  </div>
  <div>
  	<table style=" text-align: center; background-color: #00edff; width: 82%; padding: 3px;">
			<tr> 
				<th style="padding: 10px" colspan="8">TIME TABLE</th> 
			</tr>
			<tr style="background-color: #06ff00;">
				<th style="padding: 20px">TIME / DAY</th>
				<th style="padding: 20px">MONDAY</th>
				<th style="padding: 20px">TUESDAY</th>
				<th style="padding: 20px">WEDNESDAY</th>
				<th style="padding: 20px">THURSDAY</th>
				<th style="padding: 20px">FRIDAY</th>
				<th style="padding: 20px">SATURDAY</th>
				<th style="padding: 20px">SUNDAY</th>
			</tr>
			<?php
				$SQL = mysqli_query($db,"SELECT `sz_periodid` FROM `acc_periods` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'");
				$count = mysqli_num_rows($SQL);
				$i = 1;
				while($i <= $count){
					echo "<tr style='background-color: #06ff00;'>";
						$SQL = mysqli_query($db,"SELECT `sz_period` FROM `acc_timetable` WHERE sz_periodid = '$i' AND sz_classid = '$sz_classid' LIMIT 1");
						while($row = mysqli_fetch_assoc($SQL)){
							$sz_period = $row['sz_period'];
							echo "<td style='padding: 5px' title='period $i'>$sz_period</td>";
						}
						$SQL = mysqli_query($db,"SELECT `sz_per_allo`,`sz_dayid` FROM `acc_timetable` WHERE sz_periodid = '$i' AND sz_classid = '$sz_classid' ORDER BY sz_dayid");
						while($qry = mysqli_fetch_assoc($SQL)){
							$sz_per_allo = $qry['sz_per_allo'];
							$sz_dayid = $qry['sz_dayid'];

							if ($sz_dayid === '1') {
								$sz_day = 'Monday';
							}elseif ($sz_dayid === '2') {
								$sz_day = 'Tuesday';
							}elseif ($sz_dayid === '3') {
								$sz_day = 'Wednesday';
							}elseif ($sz_dayid === '4') {
								$sz_day = 'Thursday';
							}elseif ($sz_dayid === '5') {
								$sz_day = 'Friday';
							}elseif ($sz_dayid === '6') {
								$sz_day = 'Saturday';
							}elseif ($sz_dayid === '7') {
								$sz_day = 'Sunday';
							}

						echo "<td style='padding: 5px' title='$sz_day'>$sz_per_allo</td>";
					}
					echo "</tr>";
					$i++;
				}
			?>			
	</table>
	<div style="text-align: right; padding: 10px;">
		<form action="academics/pro_timetable_.php" method="post">
			<label>Period:</label> <select name="sz_periodid">
				<?php
					$SQL =  mysqli_query($db,"SELECT `sz_periodid`,`sz_period` FROM `acc_periods` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'");
					while($row = mysqli_fetch_array($SQL)){
						$sz_period = $row['sz_period'];
						$sz_periodid = $row['sz_periodid'];
						echo "<option value='$sz_periodid' title='$sz_period'> period ".$sz_periodid."</option>";
					}
				?>
			</select>
			<label>Day:</label> <select name="sz_dayid">
				<option value="0"> </option>
				<option value="1">MONDAY</option>
				<option value="2">TUESDAY</option>
				<option value="3">WEDNESDAY</option>
				<option value="4">THURSDAY</option>
				<option value="5">FRIDAY</option>
				<option value="6">SATURDAY</option>
				<option value="7">SUNDAY</option>
			</select>
			<input type="hidden" name="sz_classid" value="pri1">
			<input type="hidden" name="sz_branchid" value="gg1000zde">
			<input type="hidden" name="sz_schoolid" value="gg1000">
			<button type="submit" name="btn" value="Delete">Delete</button>
			<button type="submit" name="btn" value="DropTimeTable">Drop</button>	
		</form>
	</div>
  </div>
</body>
</html>