<?php
	function getTimeBf_f_Break($db,$class_id,$szbranch_id,$szschool_id){
		
		$SQL = mysqli_query($db,"SELECT `periods_bf_f_break` FROM `acc_timetabling_period` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id'");
		$row = mysqli_fetch_assoc($SQL);
			$periods_bf_f_break = $row['periods_bf_f_break'];
		$SQL = mysqli_query($db,"SELECT `start_time`,`end_time` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' LIMIT $periods_bf_f_break");
					
		while($row = mysqli_fetch_assoc($SQL)){
			$start_time = $row['start_time'];
			$end_time = $row['end_time'];
			$time = $start_time .' - '. $end_time;
			echo "<td>$time</td>";
		}
	}	
	function getTimeBf_s_Break($db,$class_id,$szbranch_id,$szschool_id){
		
		$SQL = mysqli_query($db,"SELECT `periods_bf_f_break`,`periods_bf_s_break` FROM `acc_timetabling_period` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id'");
		$row = mysqli_fetch_assoc($SQL);
			$periods_bf_f_break = $row['periods_bf_f_break'];
			$periods_bf_s_break = $row['periods_bf_s_break'];
		$SQL = mysqli_query($db,"SELECT `start_time`,`end_time` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' LIMIT $periods_bf_f_break, $periods_bf_s_break");
					
		while($row = mysqli_fetch_assoc($SQL)){
			$start_time = $row['start_time'];
			$end_time = $row['end_time'];
			$time = $start_time .' - '. $end_time;
			echo "<td>$time</td>";
		}
	}
	function getTime_left($db,$class_id,$szbranch_id,$szschool_id){
		
		$SQL = mysqli_query($db,"SELECT `periods_bf_f_break`,`periods_bf_s_break`,`periods_per_day` FROM `acc_timetabling_period` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id'");
		$row = mysqli_fetch_assoc($SQL);
			$periods_bf_f_break = $row['periods_bf_f_break'];
			$periods_bf_s_break = $row['periods_bf_s_break'];
			$periods_per_day = $row['periods_per_day'];
			$periods_af_breaks = (int)$periods_bf_f_break + (int)$periods_bf_s_break;
			$periods_left = ((int)$periods_per_day - (int)$periods_af_breaks);
		$SQL = mysqli_query($db,"SELECT `start_time`,`end_time` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' LIMIT $periods_af_breaks, $periods_left");
					
		while($row = mysqli_fetch_assoc($SQL)){
			$start_time = $row['start_time'];
			$end_time = $row['end_time'];
			$time = $start_time .' - '. $end_time;
			echo "<td>$time</td>";
		}
	}
	function SubBf_f_Break($db,$day,$class_id,$szbranch_id,$szschool_id){
		
		$SQL = mysqli_query($db,"SELECT * FROM `acc_timetabling_period` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id'");
		$row = mysqli_fetch_assoc($SQL);
			$periods_bf_f_break = $row['periods_bf_f_break'];
		$SQL = mysqli_query($db,"SELECT  `subject_id`,`subject_name`,`teacher_id`,`teacher_name` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' AND day = '$day' LIMIT $periods_bf_f_break");
					
		while($row = mysqli_fetch_assoc($SQL)){
			$subject_id = $row['subject_id'];
			$subject_name = $row['subject_name'];
			$teacher_id = $row['teacher_id'];
			$teacher_name = $row['teacher_name'];

			echo "<td>$subject_name</td>";
		}
	}
	function SubBf_s_Break($db,$day,$class_id,$szbranch_id,$szschool_id){
		
		$SQL = mysqli_query($db,"SELECT `periods_bf_f_break`,`periods_bf_s_break` FROM `acc_timetabling_period` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id'");
		$row = mysqli_fetch_assoc($SQL);
			$periods_bf_f_break = $row['periods_bf_f_break'];
			$periods_bf_s_break = $row['periods_bf_s_break'];
		$SQL = mysqli_query($db,"SELECT  `subject_id`,`subject_name`,`teacher_id`,`teacher_name` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' AND day = '$day' LIMIT $periods_bf_f_break, $periods_bf_s_break");
					
		while($row = mysqli_fetch_assoc($SQL)){
			$subject_id = $row['subject_id'];
			$subject_name = $row['subject_name'];
			$teacher_id = $row['teacher_id'];
			$teacher_name = $row['teacher_name'];

			echo "<td>$subject_name</td>";
		}
	}
	function Sub_left($db,$day,$class_id,$szbranch_id,$szschool_id){
		
		$SQL = mysqli_query($db,"SELECT `periods_bf_f_break`,`periods_bf_s_break`,`periods_per_day` FROM `acc_timetabling_period` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id'");
		$row = mysqli_fetch_assoc($SQL);
			$periods_bf_f_break = $row['periods_bf_f_break'];
			$periods_bf_s_break = $row['periods_bf_s_break'];
			$periods_per_day = $row['periods_per_day'];
			$periods_af_breaks = (int)$periods_bf_f_break + (int)$periods_bf_s_break;
			$periods_left = ((int)$periods_per_day - (int)$periods_af_breaks);
		$SQL = mysqli_query($db,"SELECT  `subject_id`,`subject_name`,`teacher_id`,`teacher_name` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' AND day = '$day' LIMIT $periods_af_breaks, $periods_left");
					
		while($row = mysqli_fetch_assoc($SQL)){
			$subject_id = $row['subject_id'];
			$subject_name = $row['subject_name'];
			$teacher_id = $row['teacher_id'];
			$teacher_name = $row['teacher_name'];

			echo "<td>$subject_name</td>";
		}
	}
	function Get_f_BreakTime($db,$class_id,$szbranch_id,$szschool_id){
		
		$SQL = mysqli_query($db,"SELECT `periods_bf_f_break`,`periods_bf_s_break` FROM `acc_timetabling_period` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id'");
		$row = mysqli_fetch_assoc($SQL);
			$periods_bf_f_break = $row['periods_bf_f_break'];
			$periods_bf_s_break = $row['periods_bf_s_break'];
		$SQL = mysqli_query($db,"SELECT `end_time` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' AND period_id = '$periods_bf_f_break'");
		$row = mysqli_fetch_assoc($SQL);
			$end_time = $row['end_time'];
		$periods_af_f_break = $periods_bf_f_break + 1;
		$SQL = mysqli_query($db,"SELECT `start_time` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' AND period_id = '$periods_af_f_break'");
		$row = mysqli_fetch_assoc($SQL);
			$start_time = $row['start_time'];
			$time = $end_time .' - '. $start_time;
			echo "<td>$time</td>";
	}
	function Get_s_BreakTime($db,$class_id,$szbranch_id,$szschool_id){
		
		$SQL = mysqli_query($db,"SELECT `periods_bf_f_break`,`periods_bf_s_break` FROM `acc_timetabling_period` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id'");
		$row = mysqli_fetch_assoc($SQL);
			$periods_bf_f_break = $row['periods_bf_f_break'];
			$periods_bf_s_break = $row['periods_bf_s_break'];
			$periods_bf_breaks = (int)$periods_bf_f_break + (int)$periods_bf_s_break;
		$SQL = mysqli_query($db,"SELECT `end_time` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' AND period_id = '$periods_bf_breaks'");
		$row = mysqli_fetch_assoc($SQL);
			$end_time = $row['end_time'];
		$periods_af_f_break = $periods_bf_breaks + 1;
		$SQL = mysqli_query($db,"SELECT `start_time` FROM `acc_timetable` WHERE class_id = '$class_id' AND szbranch_id = '$szbranch_id' AND szschool_id = '$szschool_id' AND period_id = '$periods_af_f_break'");
		$row = mysqli_fetch_assoc($SQL);
			$start_time = $row['start_time'];
			$time = $end_time .' - '. $start_time;
			echo "<td>$time</td>";
	}
?>