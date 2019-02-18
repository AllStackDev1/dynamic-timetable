<?php
@session_start();
//include_once("_ss_manager_setup_class_.php");
//  include_once('Lib/connect.php');
 include_once("includes/func_tt_setup_.php");
 
  $_SESSION['org'] = 'GSISCHOOL';
  $_SESSION['szbranch'] = '5';
  $_SESSION['userid'] = 'Nedu';
  $_SESSION["username"] = '';
  $_SESSION["password"] = '';
  
$c_user = isset($_SESSION["userid"]) ? $_SESSION["userid"] : false;	   
if(!$c_user) 
{
     session_destroy();
     ob_start();
     header("Location: ../eUserLog/index.html");
     ob_flush();
}


 $btn = isset($_REQUEST["btn"]) ? $_REQUEST["btn"] : false;	 
   
 if(!$btn) 
 {
     echo '{"success":false,"error":"No command"}';
     exit;
 }
 
 $db = new connection($_SESSION["username"],$_SESSION["password"]);
 $func = new TimeTableSetup($_SESSION["username"],$_SESSION["password"]);
 

if($btn == "Load") {
    
  $sz_ranges = json_decode($_REQUEST['sz_ranges']);
  $sz_term = $_REQUEST['tsz_aloc_term'];
  $sz_class = $_REQUEST['tall_classid'];
  $timetable = '{ "results":[';
  for($i = 0; $i < count($sz_ranges); $i++){
    
    // Check for an existing row...
    $records = $func->GetTimeTableData($i,$sz_ranges[$i],$sz_class,$sz_term);
    // $records .= '"sz_period":"PERIOD '.$i.'",';
    $timetable .= $records.",";
  }
  $timetable = chop($timetable, ",");
  $timetable .= '],"totalCount": '.count($sz_ranges).'}';

  echo $timetable;

//   $json = array('results'=>array(
//            array('term'=>'2nd','sz_period'=>'PERIOD 1','sz_range'=>'7:00AM-7:45AM','sz_monday'=>'ENGLISH LANGUADE','sz_tuesday'=>'MATHEMATICS','sz_wednesday'=>'GEN. SCIENCE','sz_thursday'=>'INFO. TECH.','sz_friday'=>'TECHNICAL ART','sz_saturday'=>'','sz_sunday'=>''),
//            array('term'=>'2nd','sz_period'=>'PERIOD 1','sz_range'=>'7:00AM-7:45AM','sz_monday'=>'ENGLISH LANGUADE','sz_tuesday'=>'MATHEMATICS','sz_wednesday'=>'GEN. SCIENCE','sz_thursday'=>'INFO. TECH.','sz_friday'=>'TECHNICAL ART','sz_saturday'=>'','sz_sunday'=>''),
//            array('term'=>'2nd','sz_period'=>'PERIOD 1','sz_range'=>'7:00AM-7:45AM','sz_monday'=>'ENGLISH LANGUADE','sz_tuesday'=>'MATHEMATICS','sz_wednesday'=>'GEN. SCIENCE','sz_thursday'=>'INFO. TECH.','sz_friday'=>'TECHNICAL ART','sz_saturday'=>'','sz_sunday'=>'')),
//             'totalCount'=>3);

// echo json_encode($json);

}else if($btn == "Save1"){

  $sz_days = array();

  if(isset($_REQUEST['t_mon-inputEl'])){
     array_push($sz_days,'monday');
  }
  if(isset($_REQUEST['t_tues-inputEl'])){
    array_push($sz_days,'tuesday');
  }
  if(isset($_REQUEST['t_wens-inputEl'])){
    array_push($sz_days,'wednesday');
  }
  if(isset($_REQUEST['t_thur-inputEl'])){
    array_push($sz_days,'thursday');
  }
  if(isset($_REQUEST['t_fri-inputEl'])){
    array_push($sz_days,'friday');
  }
  if(isset($_REQUEST['t_sat-inputEl'])){
    array_push($sz_days,'saturday');
  }
  if(isset($_REQUEST['t_sun-inputEl'])){
    array_push($sz_days,'sunday');
  }

    $sz_range     	= $_REQUEST['tsz_period'];
    $sz_term      	= $_REQUEST['tsz_aloc_term'];
    $sz_acayear   	= $_REQUEST['tsz_alloc_acayear'];
    $sz_class	  	  = $_REQUEST['tall_classid'];
    $sz_group     	= $_REQUEST['tsz_alllassgroup'];
    $sz_itemid    	= $_REQUEST['tall_subjectid'];
    $sz_item      	= $_REQUEST['tall_subjectname'];
    $sz_teacherid 	= $_REQUEST['tszteacherid'];
    $sz_teachername = $_REQUEST['tszteachername'];
    $sz_roomno    	= $_REQUEST['sztt_roomno'];

    if($sz_range != '' || $sz_range != "" || $sz_range != null){
      
      $add = $func->AddData($sz_days,$sz_range,$sz_itemid,$sz_item,$sz_teacherid,$sz_teachername,$sz_roomno,$sz_group,$sz_class,$sz_term,$sz_acayear);
      
      if($add == 1)
      {
        echo "{success: true,errors:{reason:'Data Successfully Saved.'}}";

      }else if($add == -2)
      {
        echo "{success: false,errors:{reason:'Period Already Allocated'}}";

      }else if($add == -3)
      {
        echo "{success: false,errors:{reason:'Teacher Unavailable'}}";

      }else if($add == -4)
      {
        echo "{success: false,errors:{reason:'Class Room Unavailable'}}";

      } else {
        echo "{success: false,errors:{reason:'Error While Allocating Period'}}";
      }

    }else{
      echo "{success: false,errors:{reason:'No Period Selected'}}";
    }
    
}else if($btn == "Edit"){
  
	$id   = $_REQUEST['id'];
	$res = $func->GetData($id);
  
   if(count($res) > 0)
     {
      //id,subject_id,subject_name,teacher_id,teacher_name,period_id,day,sz_schoolid,sz_schoolid
	    $param[0] = 'id';
	    $param[1] = 'subject_id';
	    $param[2] = 'subject_name';
	    $param[3] = 'teacher_id';
	    $param[4] = 'teacher_name';
	    $param[5] = 'period_id';
	    $param[6] = 'day';
	    $param[7] = 'sz_schoolid';
	    $param[8] = 'sz_schoolid';
	    
	    $retval = $db->RunCodeReturnJsonRC($param,$res);
	    echo $retval;
   }else {

       echo "{success: false,errors:{reason:'No Record Found..'}}";
   }       
}else if($btn == "DropPeriods"){
    $sz_class   = $_REQUEST['sz_class'];
    $sz_branchid  = $_REQUEST['sz_branchid'];
    $sz_schoolid  = $_REQUEST['sz_schoolid'];

    $drop = $func->DropPeriods($sz_class,$sz_branchid,$sz_schoolid);
     
    if($drop > 0) {
      echo "{success: true,errors:{reason:'Data Succesfully Dropped.'}}";
        
    }else{
      echo "{success: false,errors:{reason:'Error While Dropping Data'}}";
    }       
}else if($btn == "Delete"){
    
	if(isset($_REQUEST['sz_class'])){

		$sz_class   = $_REQUEST['sz_class'];
		$drop = $func->DeleteClassT($sz_class);
		if($drop > 0) {
	      
	      echo "{success: true,errors:{reason:'Timetable Succesfully Dropped.'}}";
	        
	    }else{
	      echo "{success: false,errors:{reason:'Error While Dropping Data'}}";
	    }
	    
	} else if(isset($_REQUEST['sz_group']) && isset($_REQUEST['sz_class'])){

		$sz_group   = $_REQUEST['sz_group'];
		$sz_class   = $_REQUEST['sz_class'];
		$drop = $func->DeleteGroupT($sz_group,$sz_class);
		if($drop > 0) {
	      
	      echo "{success: true,errors:{reason:'Timetable Succesfully Dropped.'}}";
	        
	    }else{
	      echo "{success: false,errors:{reason:'Error While Dropping Data'}}";
	    }

	} else{

		$drop = $func->DeleteTimetable();
		if($drop > 0) {
	      
	      echo "{success: true,errors:{reason:'Timetable Succesfully Dropped.'}}";
	        
	    }else{
	      echo "{success: false,errors:{reason:'Error While Dropping Data'}}";
	    }
	}
  
}else if($btn == "Update"){

    $sz_period    = $_REQUEST['sz_period'];
    $sz_dayid   = $_REQUEST['sz_dayid'];
    $sz_teacherid = $_REQUEST['sz_teacherid'];
    $sz_per_allo  = $_REQUEST['sz_per_allo'];
    $sz_class   = $_REQUEST['sz_class'];
    $sz_schoolid  = $_REQUEST['sz_schoolid'];
    $sz_branchid  = $_REQUEST['sz_branchid'];

    $update = $func->UpdateData($sz_period,$sz_dayid,$sz_teacherid,$sz_per_allo,$sz_class,$sz_branchid,$sz_schoolid);
     
      if($update == 1){
        echo "{success: true,errors:{reason:'Data Succesfully Updated.'}}";
      }else{
        echo "{success: false,errors:{reason:'Error While Updating Data'}}";
    }
}
